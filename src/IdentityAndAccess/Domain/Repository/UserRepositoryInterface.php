<?php

namespace App\IdentityAndAccess\Domain\Repository;

use App\IdentityAndAccess\Application\UseCase\Query\GetUserListQuery;
use App\IdentityAndAccess\Domain\Entity\User;


interface UserRepositoryInterface
{
    public function getByEmail(string $email): ?User;

    public function getById(string $id): ?User;

    public function add(User $user): void;

    public function update(User $user): void;

    public function remove(User $user): void;

    public function getByVerifyToken(string $token): ?User;

    public function getByResetToken(string $token): ?User;

    public function getAll(GetUserListQuery $query): mixed;
}