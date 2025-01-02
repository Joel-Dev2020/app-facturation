<?php

namespace App\IdentityAndAccess\Application\UseCase\User\CommandHandler;


use App\IdentityAndAccess\Application\UseCase\User\Command\EnableUserCommand;
use App\IdentityAndAccess\Domain\Entity\User;
use App\IdentityAndAccess\Domain\Exception\UserNotFoundException;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;

readonly class EnableUserHandler
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function handle(EnableUserCommand $command): User
    {
        $user = $this->repository->getById($command->id);
        if ($user === null) {
            throw UserNotFoundException::withId($command->id);
        }
        $user->setIsEnabled($command->enabled);
        return $this->repository->update($user);
    }
}