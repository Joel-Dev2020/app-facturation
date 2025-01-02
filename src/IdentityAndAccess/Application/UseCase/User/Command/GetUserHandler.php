<?php

namespace App\IdentityAndAccess\Application\UseCase\User\Command;


use App\IdentityAndAccess\Application\UseCase\User\Query\GetUserQuery;
use App\IdentityAndAccess\Domain\Entity\User;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;

class GetUserHandler
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    public function get(GetUserQuery $action): ?User
    {
        return $this->repository->getById($action->id);
    }
}