<?php

namespace App\IdentityAndAccess\Presentation\Controller\Admin\Dashboard;

use App\IdentityAndAccess\Application\UseCase\Query\GetUserListQuery;
use App\IdentityAndAccess\Application\UseCase\QueryHandler\GetUserListQueryHandler;
use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/11invoice24')]
#[IsGranted(new Expression('is_granted("ROLE_SUPER_ADMIN") or is_granted("ROLE_ADMIN") or is_granted("ROLE_USER")'))]
class DashboardController extends AbstractController
{
    #[Route(path: '/', name: 'app_admin')]
    public function dashboard(GetUserListQueryHandler $handler, Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $page = $request->query->getInt('page', 1);
        $pagination = $handler->handle(new GetUserListQuery(page: $page, userId: $user->getId()));
        return $this->render('identity_and_access/admin/dashboard/index.html.twig', [
            'title' => "Administration",
        ]);
    }
}