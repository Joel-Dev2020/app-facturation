<?php

namespace App\SharedKernel\Domain\Service\Pagination;

interface PaginationServiceInterface
{
    public function paginate(mixed $query, int $page, int $limit): mixed;
}