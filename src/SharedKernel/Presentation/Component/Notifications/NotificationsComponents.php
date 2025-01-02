<?php

namespace App\SharedKernel\Presentation\Component\Notifications;

use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Security\SecurityUser;
use App\SharedKernel\Domain\Entity\Notification\Notification;
use App\SharedKernel\Domain\Repository\Notification\NotificationRepositoryInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('NotificationsComponent', template: 'shared_kernel/notification/components/notifications_component.html.twig')]
class NotificationsComponents
{
    public ?SecurityUser $user = null;

    public function __construct(private readonly NotificationRepositoryInterface $repository)
    {
    }

    /**
     * @return Notification[]|null
     */
    public function getNotifications(): ?array
    {
        return $this->repository->getUnreadNotifs($this->user);
    }

    public function countNotifs(): int
    {
        return $this->repository->countNotifs($this->user);
    }
}