<?php

namespace App\IdentityAndAccess\Presentation\Controller\Admin\User;

use App\IdentityAndAccess\Application\UseCase\ResetPassword\Command\EmailRequestCommand;
use App\IdentityAndAccess\Application\UseCase\ResetPassword\Command\ResetPasswordCommand;
use App\IdentityAndAccess\Application\UseCase\ResetPassword\CommandHandler\EmailRequestHandler;
use App\IdentityAndAccess\Application\UseCase\ResetPassword\CommandHandler\ResetPasswordHandler;
use App\IdentityAndAccess\Domain\Event\User\UserNotifierEvent;
use App\IdentityAndAccess\Domain\Exception\UserNotFoundException;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use App\IdentityAndAccess\Presentation\Form\ResetPassword\EmailRequestType;
use App\IdentityAndAccess\Presentation\Form\ResetPassword\ResetPasswordType;
use App\SharedKernel\Presentation\Service\Session\FlashService;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/password-reset')]
class PasswordResetController extends AbstractController
{
    private const TOKEN = 'resetToken';

    public function __construct(
        private readonly FlashService    $flash,
        private readonly LoggerInterface $logger
    )
    {
    }

    #[Route(path: '/request', name: 'password.request', methods: ['GET', 'POST'])]
    public function requestReset(
        Request                  $request,
        EmailRequestHandler      $handler,
        EventDispatcherInterface $eventDispatcher
    ): Response
    {
        // Envoyer un email avec le lien contenant le token
        // Exemple : http://example.com/password-reset/confirm?token=$token
        $command = new EmailRequestCommand();
        $form = $this->createForm(EmailRequestType::class, $command);
        $form->handleRequest($request);
        $referer = $request->headers->get('referer');
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $user = $handler->handle(command: $command);
                try {
                    $eventDispatcher->dispatch(new UserNotifierEvent(
                        email: $user->getEmail(),
                        userId: $user->id,
                        subject: "Réinitialisation de mot de passe",
                        template: 'identity_and_access/web/reset_password/email.html.twig',
                        data: ['resetToken' => $user],
                    ));
                    $session = $request->getSession();
                    $session->set(self::TOKEN, $user->getPasswordResetToken());
                    return $this->redirectToRoute('app_check_email');
                } catch (UserNotFoundException $e) {
                    $this->flash->danger($e->getMessage());
                    return new RedirectResponse($referer);
                }
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
        return $this->render('identity_and_access/web/reset_password/request.html.twig', [
            'title' => "Réinitialisation de mot de passe",
            'user' => $command,
            'requestForm' => $form,
        ]);
    }

    #[Route('/check-email', name: 'app_check_email')]
    public function checkEmail(Request $request, UserRepositoryInterface $repository): Response
    {
        $session = $request->getSession();
        $token = $session->get(self::TOKEN);
        $user = $repository->getByResetToken($token);
        if (!$user) {
            throw UserNotFoundException::withToken($token);
        }

        return $this->render('identity_and_access/web/reset_password/check_email.html.twig', [
            'resetToken' => $user,
        ]);
    }

    #[Route(path: '/confirm/{token}', name: 'password.reset', methods: ['GET', 'POST'])]
    public function resetPassword(
        Request                 $request,
        ResetPasswordHandler    $handler,
        string                  $token,
        UserRepositoryInterface $repository
    ): Response
    {
        if (!$token) {
            $this->flash->danger('Token invalide, veuillez réessayer.');
            return $this->redirectToRoute('app_login');
        }

        $user = $repository->getByResetToken($token);
        if (!$user) {
            $this->flash->danger('Aucun utilisateur trouvé, veuillez réessayer.');
            return $this->redirectToRoute('app_login');
        }

        $command = new ResetPasswordCommand(token: $token);
        $form = $this->createForm(ResetPasswordType::class, $command);
        $form->handleRequest($request);
        $referer = $request->headers->get('referer');

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle(command: $command);
                $this->flash->success("Votre mot de passe a bien été reinitialisé.");
                $session = $request->getSession();
                $session->remove(self::TOKEN);
                return $this->redirectToRoute('app_login');
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

        return $this->render('identity_and_access/web/reset_password/reset.html.twig', [
            'title' => "Nouveau mot de passe",
            'resetForm' => $form,
        ]);
    }
}