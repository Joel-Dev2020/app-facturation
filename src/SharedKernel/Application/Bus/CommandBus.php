<?php

namespace App\SharedKernel\Application\Bus;

interface CommandBus
{
    public function handle(object $command): mixed;
}