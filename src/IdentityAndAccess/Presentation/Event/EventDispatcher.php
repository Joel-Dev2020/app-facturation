<?php

namespace App\IdentityAndAccess\Presentation\Event;

use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class EventDispatcher
{
    public function __construct(private MessageBusInterface $eventBus)
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function dispatchAll(array $events): void
    {
        foreach ($events as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}