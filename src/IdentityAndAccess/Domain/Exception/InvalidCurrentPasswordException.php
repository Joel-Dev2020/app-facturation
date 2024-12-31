<?php

namespace App\IdentityAndAccess\Domain\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Throwable;

class InvalidCurrentPasswordException extends AuthenticationException
{
    public function __construct(string $message = "Le mot de passe actuel n'est pas valide.", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getMessageKey(): string
    {
        return "Le mot de passe actuel n'est pas valide.";
    }
}