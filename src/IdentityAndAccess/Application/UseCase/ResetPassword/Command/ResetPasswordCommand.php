<?php

namespace App\IdentityAndAccess\Application\UseCase\ResetPassword\Command;

class ResetPasswordCommand
{
    public ?string $token;
    public ?string $password;

    public function __construct(?string $password = null, ?string $token = null)
    {
        $this->password = $password;
        $this->token = $token;
    }
}