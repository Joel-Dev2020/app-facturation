<?php

namespace App\IdentityAndAccess\Application\UseCase\ResetPassword\Command;

class EmailRequestCommand
{
    public ?string $email;

    public function __construct(?string $email = null)
    {
        $this->email = $email;
    }
}