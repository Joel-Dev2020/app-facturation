<?php

namespace App\SharedKernel\Application\Bus;

interface QueryBus
{
    public function handle(object $command): mixed;
}