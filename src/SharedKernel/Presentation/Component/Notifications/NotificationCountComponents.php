<?php

namespace App\SharedKernel\Presentation\Component\Notifications;

use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Security\SecurityUser;
use App\SharedKernel\Domain\Repository\Notification\NotificationRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('NotificationCountComponent', template: 'shared_kernel/notification/components/notifications_count_component.html.twig')]
class NotificationCountComponents extends AbstractController
{
    public ?bool $isHeader = false;
    public ?SecurityUser $user = null;

    public function __construct(private readonly NotificationRepositoryInterface $repository)
    {
    }

    public function getNotificationsCount(): int
    {
        return $this->repository->countNotifs($this->user);
    }
}