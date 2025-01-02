<?php

namespace App\IdentityAndAccess\Presentation\Controller\Admin\User;

use App\IdentityAndAccess\Application\UseCase\User\Command\ChangeUserPasswordCommand;
use App\IdentityAndAccess\Application\UseCase\User\Command\CreateUserCommand;
use App\IdentityAndAccess\Application\UseCase\User\Command\DeleteUserCommand;
use App\IdentityAndAccess\Application\UseCase\User\Command\GetUserHandler;
use App\IdentityAndAccess\Application\UseCase\User\Command\UpdateUserCommand;
use App\IdentityAndAccess\Application\UseCase\User\CommandHandler\ChangeUserPasswordHandler;
use App\IdentityAndAccess\Application\UseCase\User\CommandHandler\CreateUserHandler;
use App\IdentityAndAccess\Application\UseCase\User\CommandHandler\DeleteUserHandler;
use App\IdentityAndAccess\Application\UseCase\User\CommandHandler\UpdateUserHandler;
use App\IdentityAndAccess\Application\UseCase\User\Query\GetUserListQuery;
use App\IdentityAndAccess\Application\UseCase\User\Query\GetUserQuery;
use App\IdentityAndAccess\Domain\Event\User\UserNotifierEvent;
use App\IdentityAndAccess\Domain\Exception\PasswordNotIdenticalException;
use App\IdentityAndAccess\Domain\Exception\UserNotFoundException;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\User as UserEntity;
use App\IdentityAndAccess\Presentation\Form\SearchUserQueryType;
use App\IdentityAndAccess\Presentation\Form\UserEditType;
use App\IdentityAndAccess\Presentation\Form\UsersChangePasswordType;
use App\IdentityAndAccess\Presentation\Form\UserType;
use App\SharedKernel\Domain\Service\Context\ContextInterface;
use App\SharedKernel\Domain\Service\Pagination\PaginationServiceInterface;
use App\SharedKernel\Presentation\Service\Session\FlashService;
use DomainException;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/11invoice24/users')]
#[IsGranted(new Expression('is_granted("ROLE_SUPER_ADMIN") or is_granted("ROLE_ADMIN") or is_granted("ROLE_USER")'))]
class UserController extends AbstractController
{
    public function __construct(
        private readonly FlashService            $flash,
        private readonly ContextInterface        $context,
        private readonly LoggerInterface         $logger,
        private readonly UserRepositoryInterface $repository
    )
    {
    }

    #[Route(path: '/', name: 'admin.users.index', methods: ['GET'])]
    #[IsGranted(new Expression('is_granted("ROLE_LIST")'))]
    public function index(
        Request                    $request,
        UserRepositoryInterface    $repository,
        PaginationServiceInterface $paginationService
    ): Response
    {
        $title = "Gestion des utilisateurs";
        /** @var UserEntity $admin */
        $admin = $this->getUser();

        $page = $request->query->getInt('page', 1);
        $search = new GetUserListQuery(
            page: $page,
            limit: intval($this->context->getValue('app_paginate_limit')),
            userId: $admin->getId(),
        );
        $form = $this->createForm(SearchUserQueryType::class, $search);
        $form->handleRequest($request);

        $query = $repository->getAll($search);
        if ($form->isSubmitted() && $form->isValid()) {
            $query = $repository->getAll($search);
        }
        $users = $paginationService->paginate($query, $search->page, $search->limit);

        return $this->render('identity_and_access/admin/user/index.html.twig', [
            'title' => $title,
            'search' => $search,
            'form' => $form->createView(),
            'users' => $users,
        ]);
    }

    #[Route(path: '/create', name: 'admin.users.create', methods: ['GET', 'POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_CREATE")'))]
    public function create(Request $request, CreateUserHandler $handler, EventDispatcherInterface $eventDispatcher): Response
    {
        $command = new CreateUserCommand(owner: $this->getUser());
        $form = $this->createForm(UserType::class, $command);
        $form->handleRequest($request);
        $referer = $request->headers->get('referer');

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $handler->handle(command: $command);
                if ($user->id) {
                    // On envois les informations de l'utilisateur par mail
                    $message = sprintf(
                        "Votre compte a bien été crée.\nAdresse email: %s\nMot de passe: %s",
                        $user->getEmail(),
                        $form->get('password')->getData()
                    );
                    try {
                        $eventDispatcher->dispatch(new UserNotifierEvent(
                            email: $user->getEmail(),
                            userId: $user->id,
                            subject: "Création de votre compte utilisateur",
                            message: $message,
                        ));
                    } catch (UserNotFoundException $e) {
                        $this->flash->danger($e->getMessage());
                        return new RedirectResponse($referer);
                    }
                }
                $this->flash->success(sprintf("Utilisateur %s crée avec succès", $user->getName()));
                return new RedirectResponse($referer);
            } catch (UserNotFoundException $e) {
                // Renvoyer une réponse significative lorsque l'e-mail existe déjà
                $this->logger->error($e->getMessage());
                $this->flash->danger($e->getMessage());
                return new RedirectResponse($referer);
            } catch (Exception $e) {
                $this->logger->error($e->getMessage());
                $this->flash->danger("Une erreur inattendue s'est produite.");
                return new RedirectResponse($referer);
            }
        }

        return $this->render('identity_and_access/admin/user/create.html.twig', [
            'title' => "Créer un utilisateur",
            'user' => $command,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/update/{id}', name: 'admin.users.update', methods: ['GET', 'POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_EDIT")'))]
    public function update(Request $request, string $id, UpdateUserHandler $handler): Response
    {
        $referer = $request->headers->get('referer');
        $user = $this->repository->getById($id);

        if (!$user) {
            $this->flash->danger("Utilisateur inconnu.");
            return new RedirectResponse($referer);
        }

        $action = new UpdateUserCommand(
            id: $user->id,
            organization: $user->getOrganization(),
            name: $user->getName(),
            email: $user->getEmail(),
            phone_number: $user->getPhoneNumber(),
            address: $user->getAddress(),
            enabled: $user->getIsEnabled(),
            is_free: $user->getIsFree(),
        );
        $form = $this->createForm(UserEditType::class, $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $data = $handler->handle(command: $action);
                if ($data->id) {
                    $this->flash->success(sprintf("Utilisateur %s modifié avec succès", $data->getName()));
                    return new RedirectResponse($referer);
                }
            } catch (DomainException $e) {
                $this->logger->error($e->getMessage());
                $this->flash->danger($e->getMessage());
            }
        }
        return $this->render('identity_and_access/admin/user/update.html.twig', [
            'title' => "Modifier l'utilisateur",
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/change-password/{id}', name: 'admin.users.change_password', methods: ['POST'])]
    #[IsGranted(new Expression('is_granted("ROLE_EDIT")'))]
    public function changePassword(Request $request, string $id, ChangeUserPasswordHandler $handler): Response
    {
        $referer = $request->headers->get('referer');
        $user = $this->repository->getById($id);
        if (!$user) {
            $this->flash->danger("Utilisateur inconnu.");
            return new RedirectResponse($referer);
        }
        $isMe = $request->query->getBoolean('isMe');
        $action = new ChangeUserPasswordCommand(id: $user->id, isMe: $isMe);
        $form = $this->createForm(UsersChangePasswordType::class, $action, ['isMe' => $isMe]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($action);
                if ($isMe) {
                    $msg = "Votre mot de passe a été modifié avec succès";
                } else {
                    $msg = sprintf("Mot de passe pour %s a été modifié avec succès", $user->getName());
                }
                $this->flash->success($msg);
                return new RedirectResponse($referer);
            } catch (PasswordNotIdenticalException $e) {
                $this->logger->error($e->getMessage());
                $this->flash->danger($e->getMessage());
                return new RedirectResponse($referer);
            }
        }
        $this->flash->danger("Une erreur est survenue, veuillez réessayer!");
        return new RedirectResponse($referer);
    }

    #[Route(path: '/view/{id}', name: 'admin.users.view', methods: ['GET'])]
    #[IsGranted(new Expression('is_granted("ROLE_VIEW")'))]
    public function view(Request $request, string $id, GetUserHandler $handler): Response
    {
        $referer = $request->headers->get('referer');
        $user = $handler->get(new GetUserQuery(id: $id));
        if (!$user) {
            $this->flash->danger("Utilisateur inconnu.");
            return new RedirectResponse($referer);
        }

        return $this->render('identity_and_access/admin/user/view.html.twig', [
            'title' => 'Informations utilisateur',
            'user' => $user,
        ]);
    }

    #[Route(path: '/delete/{id}', name: 'admin.users.delete', methods: ['DELETE'])]
    #[IsGranted(new Expression('is_granted("ROLE_DELETE")'))]
    public function delete(Request $request, string $id, DeleteUserHandler $handler): Response
    {
        $referer = $request->headers->get('referer');
        $user = $this->repository->getById($id);
        if (!$user) {
            $this->flash->danger("Utilisateur inconnu.");
            return new RedirectResponse($referer);
        }
        if ($this->isCsrfTokenValid('delete' . $user->id, $request->request->get('_token'))) {
            try {
                $action = new DeleteUserCommand(id: $user->id);
                $handler->handle(command: $action);
                $this->flash->success(sprintf("Utilisateur %s supprimé avec succès", $user->getName()));
                return new RedirectResponse($referer);
            } catch (PasswordNotIdenticalException $e) {
                $this->logger->error($e->getMessage());
                $this->flash->danger($e->getMessage());
                return new RedirectResponse($referer);
            }
        }
        $this->flash->danger("Une erreur est survenue, veuillez réessayer!");
        return new RedirectResponse($referer);
    }
}