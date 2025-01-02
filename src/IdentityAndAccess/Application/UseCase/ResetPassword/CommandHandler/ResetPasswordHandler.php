<?php

namespace App\IdentityAndAccess\Application\UseCase\ResetPassword\CommandHandler;

use App\IdentityAndAccess\Application\UseCase\ResetPassword\Command\ResetPasswordCommand;
use App\IdentityAndAccess\Domain\Entity\User;
use App\IdentityAndAccess\Domain\Exception\UserNotFoundException;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use App\IdentityAndAccess\Domain\Service\Password\PasswordHasherInterface;

readonly class ResetPasswordHandler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private PasswordHasherInterface $hasher,
    )
    {
    }

    public function handle(ResetPasswordCommand $command): User
    {
        // On vérifie si l'email existe déja
        $user = $this->repository->getByResetToken($command->token);

        if (!$user) {
            throw  UserNotFoundException::withToken($command->token);
        }
        if ($user->isPasswordResetTokenExpired()) {
            throw  UserNotFoundException::withTokenExpired($command->token);
        }

        $passwordHash = $this->hasher->hashReset($user, $command->password);
        $user->setPassword($passwordHash);

        $result = $this->repository->update($user);
        if ($result->getPasswordResetToken()) {
            // On réinitialise les champs
            $user->setPasswordResetToken(null);
            $user->setPasswordResetExpiresAt(null);
            $result = $this->repository->update($user);
        }
        return $result;
    }
}