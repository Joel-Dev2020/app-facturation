<?php

namespace App\IdentityAndAccess\Application\UseCase\ResetPassword\CommandHandler;

use App\IdentityAndAccess\Application\UseCase\ResetPassword\Command\EmailRequestCommand;
use App\IdentityAndAccess\Domain\Entity\User;
use App\IdentityAndAccess\Domain\Exception\UserNotFoundException;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use App\SharedKernel\Infrastructure\Framework\Symfony\Port\Helper\UuidTokenGenerator;
use DateTime;

readonly class EmailRequestHandler
{
    public function __construct(private UserRepositoryInterface $repository, private UuidTokenGenerator $generator)
    {
    }

    public function handle(EmailRequestCommand $command): User
    {
        // On vérifie si l'email existe déja
        $user = $this->repository->getByEmail($command->email);
        if (!$user) {
            throw  UserNotFoundException::withEmail($command->email);
        }
        $user->setPasswordResetRequestedAt(new DateTime());
        $user->setPasswordResetToken($this->generator->generateToken());
        $user->setPasswordResetExpiresAt((new DateTime())->modify('+24 hours'));
        return $this->repository->update($user);
    }
}