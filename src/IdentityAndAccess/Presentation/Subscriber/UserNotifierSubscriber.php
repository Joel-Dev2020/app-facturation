<?php

namespace App\IdentityAndAccess\Presentation\Subscriber;

use App\IdentityAndAccess\Domain\Event\User\UserNotifierEvent;
use App\IdentityAndAccess\Domain\Exception\UserNotFoundException;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use App\IdentityAndAccess\Presentation\Service\Mailer\UserNotifierService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserNotifierSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly UserNotifierService     $notifier
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserNotifierEvent::class => [['sendUserNotification', 1]]
        ];
    }

    public function sendUserNotification(UserNotifierEvent $event): void
    {
        $user = $this->repository->getByEmail($event->getEmail());
        if (!$user) {
            throw UserNotFoundException::withEmail($event->getEmail());
        }

        $this->notifier->send(
            to: $user->getEmail(),
            subject: $event->getSubject(),
            body: $event->getMessage() ?? null,
            template: $event->getTemplate() ?? null,
            data: $event->getData(),
        );
    }
}