<?php

namespace App\IdentityAndAccess\Application\UseCase\User\CommandHandler;

use App\IdentityAndAccess\Application\UseCase\User\Command\ChangeUserPasswordCommand;
use App\IdentityAndAccess\Domain\Exception\InvalidCurrentPasswordException;
use App\IdentityAndAccess\Domain\Exception\UserNotFoundException;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use App\IdentityAndAccess\Domain\Service\Password\PasswordHasherInterface;
use App\SharedKernel\Application\Bus\CommandHandler;

readonly class ChangeUserPasswordHandler implements CommandHandler
{
    public function __construct(private UserRepositoryInterface $repository, private PasswordHasherInterface $hasher)
    {
    }

    public function handle(ChangeUserPasswordCommand $command): void
    {
        $user = $this->repository->getById($command->id);
        if ($user === null) {
            throw UserNotFoundException::withId($command->id);
        }

        if ($command->isMe) {
            $validPassword = $this->hasher->isValid($command->currentPassword);
            if (!$validPassword) {
                throw new InvalidCurrentPasswordException();
            }
        }

        $passwordHash = $this->hasher->hash($command->password);
        $user->setPassword($passwordHash);

        $this->repository->update($user);
    }
}