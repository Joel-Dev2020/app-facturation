<?php

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Service\Pagination;


use App\SharedKernel\Domain\Service\Pagination\PaginationServiceInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

readonly class PaginationService implements PaginationServiceInterface
{
    public function __construct(private PaginatorInterface $paginator)
    {
    }

    /**
     * @param mixed $query
     * @param int $page
     * @param int $limit
     * @return PaginationInterface
     */
    public function paginate(mixed $query, int $page, int $limit): PaginationInterface
    {
        return $this->paginator->paginate($query, $page, $limit);
    }
}