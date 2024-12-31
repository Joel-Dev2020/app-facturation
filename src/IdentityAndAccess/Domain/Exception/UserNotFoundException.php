<?php

namespace App\IdentityAndAccess\Domain\Exception;

use App\SharedKernel\Domain\Model\Exception\UserFacingError;
use DomainException;

final class UserNotFoundException extends DomainException implements UserFacingError
{
    public static function withEmail(string $email): self
    {
        return new self(sprintf('Aucun utilisateur ne correspond à cet email %s', $email));
    }

    public static function withToken(string $token): self
    {
        return new self(sprintf('Aucun utilisateur ne correspond à ce token %s', $token));
    }

    public static function withId(string $id): self
    {
        return new self(sprintf('Aucun utilisateur ne correspond à cet identifiant %s', $id));
    }
}