<?php

namespace App\IdentityAndAccess\Domain\Exception;

use App\SharedKernel\Domain\Exception\UserFacingError;
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

    public static function withTokenExpired(string $token): self
    {
        return new self(sprintf('Ce token %s à expiré', $token));
    }

    public static function withId(string $id): self
    {
        return new self(sprintf('Aucun utilisateur ne correspond à cet identifiant %s', $id));
    }
}