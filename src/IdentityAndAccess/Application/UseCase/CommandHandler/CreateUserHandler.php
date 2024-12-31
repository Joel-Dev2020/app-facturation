<?php

namespace App\IdentityAndAccess\Application\UseCase\CommandHandler;

use App\IdentityAndAccess\Application\UseCase\Command\CreateUserCommand;
use App\IdentityAndAccess\Domain\Entity\User;
use App\IdentityAndAccess\Domain\Exception\EmailAlreadyExistsException;
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
        if ($this->repository->getByEmail($command->email)) {
            throw new EmailAlreadyExistsException($command->email);
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
        );

        $this->repository->add($user);
        return $user;
    }
}