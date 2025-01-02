<?php

namespace App\IdentityAndAccess\Application\UseCase\User\CommandHandler;


use App\IdentityAndAccess\Application\UseCase\User\Command\UpdateUserCommand;
use App\IdentityAndAccess\Domain\Entity\User;
use App\IdentityAndAccess\Domain\Exception\UserNotFoundException;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use DomainException;

readonly class UpdateUserHandler
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function handle(UpdateUserCommand $command): User
    {
        $user = $this->repository->getById($command->id);
        $this->checkIfModify($user, $command);
        if ($user === null) {
            throw UserNotFoundException::withId($command->id);
        }
        $user->setOrganization($command->organization);
        $user->setName($command->name);
        $user->setEmail($command->email);
        $user->setPhoneNumber($command->phone_number);
        $user->setAddress($command->address);
        $user->setIsEnabled($command->enabled);
        $user->setIsFree($command->is_free);
        return $this->repository->update($user);
    }

    private function checkIfModify(User $user, UpdateUserCommand $command): void
    {
        if (
            $user->getOrganization() === $command->organization &&
            $user->getName() === $command->name &&
            $user->getEmail() === $command->email &&
            $user->getPhoneNumber() === $command->phone_number &&
            $user->getAddress() === $command->address &&
            $user->getIsEnabled() === $command->enabled &&
            $user->getIsFree() === $command->is_free
        ) {
            throw new DomainException("Aucun changement n'a été détecté pour la mise à jour de l'utilisateur.");
        }
    }
}