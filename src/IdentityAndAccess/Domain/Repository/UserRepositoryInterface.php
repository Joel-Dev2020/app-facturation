<?php

namespace App\IdentityAndAccess\Domain\Repository;

use App\IdentityAndAccess\Application\UseCase\User\Query\GetUserListQuery;
use App\IdentityAndAccess\Domain\Entity\User;


interface UserRepositoryInterface
{
    public function getByEmail(string $email): ?User;

    public function getById(string $id): ?User;

    public function add(User $user): ?User;

    public function update(User $user): ?User;

    public function remove(User $user): void;

    public function getByResetToken(string $token): ?User;

    public function getAll(GetUserListQuery $query): mixed;
}