<?php

namespace App\SharedKernel\Infrastructure\Bus;

use App\SharedKernel\Application\Bus\AsyncMessage;
use App\SharedKernel\Application\Bus\MessageBus;

class MessengerMessageBus implements MessageBus
{

    /**
     * @param AsyncMessage $message
     * @return void
     */
    public function dispatch(AsyncMessage $message): void
    {
        // TODO: Implement dispatch() method.
    }
}