<?php

namespace App\IdentityAndAccess\Domain\Exception;

use App\SharedKernel\Domain\Exception\UserFacingError;
use DomainException;

final class TokenNotFoundException extends DomainException implements UserFacingError
{
    public static function withToken(string $token): self
    {
        return new self(sprintf("Ce token %s n'existe pas", $token));
    }
}