<?php

namespace App\SharedKernel\Infrastructure\Bus;

use App\SharedKernel\Application\Bus\QueryBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

class MessengerQueryBus implements QueryBus
{
    use HandleTrait {
        HandleTrait::handle as messengerHandle;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @param object $command
     * @return mixed
     * @throws Throwable
     */
    public function handle(object $command): mixed
    {
        try {
            return $this->messengerHandle($command);
        } catch (HandlerFailedException $e) {
            while ($e instanceof HandlerFailedException) {
                /** @var Throwable $e */
                $e = $e->getMessage();
            }
            throw $e;
        }
    }
}