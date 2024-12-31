<?php

namespace App\IdentityAndAccess\Domain\Service\Password;

interface PasswordHasherInterface
{
    public function hash(string $plainPassword): string;

    public function isValid(string $plainPassword): bool;
}