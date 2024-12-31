<?php

namespace App\IdentityAndAccess\Application\UseCase\CommandHandler;


use App\IdentityAndAccess\Application\UseCase\Command\UpdateProfileCommand;
use App\IdentityAndAccess\Domain\Entity\User;
use App\IdentityAndAccess\Domain\Exception\UserNotFoundException;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;

readonly class UpdateProfileHandler
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function handle(UpdateProfileCommand $command): User
    {
        $user = $this->repository->getById($command->id);
        if ($user === null) {
            throw UserNotFoundException::withId($command->id);
        }
        $this->repository->update($user);
        return $user;
    }
}