<?php

namespace App\IdentityAndAccess\Application\UseCase\Command;

readonly class DeleteUserCommand
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}