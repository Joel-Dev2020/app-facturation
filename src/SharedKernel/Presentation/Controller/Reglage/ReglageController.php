<?php

namespace App\SharedKernel\Presentation\Controller\Reglage;

use App\IdentityAndAccess\Application\UseCase\Query\GetUserListQuery;
use App\IdentityAndAccess\Application\UseCase\QueryHandler\GetUserListQueryHandler;
use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/11invoice24/reglage')]
#[IsGranted(new Expression('is_granted("ROLE_SUPER_ADMIN")'))]
class ReglageController extends AbstractController
{
    #[Route(path: '/', name: 'app_reglage')]
    public function dashboard(GetUserListQueryHandler $handler, Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $page = $request->query->getInt('page', 1);
        $pagination = $handler->handle(new GetUserListQuery(page: $page, userId: $user->getId()));
        return $this->render('shared_kernel/reglage/index.html.twig', [
            'title' => "Reglage",
        ]);
    }
}