<?php

namespace App\IdentityAndAccess\Application\UseCase\User\CommandHandler;


use App\IdentityAndAccess\Application\UseCase\User\Command\UpdateProfileCommand;
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
        $user->setOrganization($command->organization);
        $user->setName($command->name);
        $user->setEmail($command->email);
        $user->setPhoneNumber($command->phone_number);
        $user->setAddress($command->address);
        return $this->repository->update($user);
    }
}