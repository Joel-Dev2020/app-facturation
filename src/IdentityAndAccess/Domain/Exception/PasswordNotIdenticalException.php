<?php

namespace App\IdentityAndAccess\Domain\Exception;

use DomainException;

class PasswordNotIdenticalException extends DomainException
{
    public function __construct(string $message = "Les mots de passe renseignés ne sont pas identiques.")
    {
        parent::__construct($message);
    }
}