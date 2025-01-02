<?php

namespace App\IdentityAndAccess\Application\UseCase\User\CommandHandler;

use App\IdentityAndAccess\Application\UseCase\User\Command\CreateUserCommand;
use App\IdentityAndAccess\Domain\Entity\User;
use App\IdentityAndAccess\Domain\Exception\UserNotFoundException;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use App\IdentityAndAccess\Domain\Service\Password\PasswordHasherInterface;

readonly class CreateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private PasswordHasherInterface $hasher,
    )
    {
    }

    public function handle(CreateUserCommand $command): User
    {
        // On vérifie si l'email existe déja
        if (!$this->repository->getByEmail($command->email)) {
            throw  UserNotFoundException::withEmail($command->email);
        }
        $passwordHash = $this->hasher->hash($command->password);
        $user = new User(
            organization: $command->organization,
            name: $command->name,
            email: $command->email,
            password: $passwordHash,
            phone_number: $command->phone_number,
            address: $command->address,
            is_enabled: $command->is_enabled,
            roles: $command->roles,
            owner: ($command->owner !== null && $command->owner->isAdmin) ? $command->owner : null,
        );
        return $this->repository->add($user);
    }
}