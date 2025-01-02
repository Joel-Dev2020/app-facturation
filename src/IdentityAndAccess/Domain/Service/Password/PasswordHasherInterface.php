<?php

namespace App\IdentityAndAccess\Domain\Service\Password;

use App\IdentityAndAccess\Domain\Entity\User;

interface PasswordHasherInterface
{
    public function hash(string $plainPassword): string;

    public function hashReset(User $user, string $plainPassword): string;

    public function isValid(string $plainPassword): bool;
}