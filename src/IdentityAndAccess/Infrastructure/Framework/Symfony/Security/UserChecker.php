<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Security;

use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

        // L’utilisateur n’est pas activé par l’administrateur
        if (!$user->getEnabled()) {
            throw new CustomUserMessageAccountStatusException("Votre compte n'est pas actif");
        }
    }

    /**
     * @param UserInterface $user
     */
    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }
        if (!$user->getEnabled()) {
            throw new CustomUserMessageAccountStatusException("Votre compte n'est pas actif");
        }
    }
}
