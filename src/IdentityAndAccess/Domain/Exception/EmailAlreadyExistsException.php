<?php

namespace App\IdentityAndAccess\Domain\Exception;

use DomainException;

class EmailAlreadyExistsException extends DomainException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf("L'adresse email %s est déjà utilisé.", $email));
    }
}