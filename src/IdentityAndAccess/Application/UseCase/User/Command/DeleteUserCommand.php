<?php

namespace App\IdentityAndAccess\Application\UseCase\User\Command;

class DeleteUserCommand
{
    public string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}