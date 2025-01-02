<?php

namespace App\IdentityAndAccess\Application\UseCase\User\CommandHandler;

use App\IdentityAndAccess\Application\UseCase\User\Command\DeleteUserCommand;
use App\IdentityAndAccess\Domain\Exception\UserNotFoundException;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;

readonly class DeleteUserHandler
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function handle(DeleteUserCommand $command): void
    {
        $user = $this->repository->getById($command->id);
        if ($user === null) {
            throw UserNotFoundException::withId($command->id);
        }
        $this->repository->remove($user);
    }
}