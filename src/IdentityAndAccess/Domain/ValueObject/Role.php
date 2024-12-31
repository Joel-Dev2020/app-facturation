<?php
declare(strict_types=1);

namespace App\IdentityAndAccess\Domain\ValueObject;

enum Role: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';
    case SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    public function label(): string
    {
        return match ($this) {
            self::USER => 'User',
            self::ADMIN => 'Administrator',
            self::SUPER_ADMIN => 'Super Administrator',
        };
    }
}
