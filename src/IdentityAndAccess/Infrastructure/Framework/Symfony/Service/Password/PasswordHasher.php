<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Service\Password;

use App\IdentityAndAccess\Domain\Entity\User;
use App\IdentityAndAccess\Domain\Service\Password\PasswordHasherInterface;
use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Security\SecurityUser;
use App\IdentityAndAccess\Infrastructure\Mapper\UserMapper;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class PasswordHasher implements PasswordHasherInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher, private Security $security)
    {
    }

    public function hash(string $plainPassword): string
    {
        /** @var SecurityUser $user */
        $user = $this->security->getUser();
        return $this->hasher->hashPassword($user, $plainPassword);
    }

    public function isValid(string $plainPassword): bool
    {
        /** @var SecurityUser $user */
        $user = $this->security->getUser();
        return $this->hasher->isPasswordValid($user, $plainPassword);
    }

    public function hashReset(User $user, string $plainPassword): string
    {
        $doctrineUser = UserMapper::toInfrastructure($user);
        return $this->hasher->hashPassword($doctrineUser, $plainPassword);
    }
}