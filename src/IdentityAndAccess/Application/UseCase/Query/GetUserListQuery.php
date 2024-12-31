<?php

namespace App\IdentityAndAccess\Application\UseCase\Query;

class GetUserListQuery
{
    public function __construct(
        public int     $page = 1,
        public ?int    $limit = 10,
        public ?string $organization = null,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $userId = null,
    )
    {
    }
}