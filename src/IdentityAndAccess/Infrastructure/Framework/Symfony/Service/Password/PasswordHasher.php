<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Service\Password;

use App\IdentityAndAccess\Domain\Service\Password\PasswordHasherInterface;
use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class PasswordHasher implements PasswordHasherInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher, private Security $security)
    {
    }

    public function hash(string $plainPassword): string
    {
        /** @var User $user */
        $user = $this->security->getUser();
        return $this->hasher->hashPassword($user, $plainPassword);
    }

    public function isValid(string $plainPassword): bool
    {
        /** @var User $user */
        $user = $this->security->getUser();
        return $this->hasher->isPasswordValid($user, $plainPassword);
    }
}