<?php

namespace App\IdentityAndAccess\Application\UseCase\User\QueryHandler;

use App\IdentityAndAccess\Application\UseCase\User\Query\GetUserListQuery;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use App\SharedKernel\Domain\Service\Pagination\PaginationServiceInterface;

readonly class GetUserListQueryHandler
{
    public function __construct(private UserRepositoryInterface $repository, private PaginationServiceInterface $paginationService)
    {
    }

    public function handle(GetUserListQuery $query): mixed
    {
        return $this->paginationService->paginate($this->repository->getAll($query), $query->page, $query->limit);
    }
}