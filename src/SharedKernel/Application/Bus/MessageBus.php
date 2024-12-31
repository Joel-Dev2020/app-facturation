<?php

namespace App\SharedKernel\Application\Bus;

interface MessageBus
{
    public function dispatch(AsyncMessage $message): void;
}