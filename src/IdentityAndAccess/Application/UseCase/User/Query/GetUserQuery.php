<?php

namespace App\IdentityAndAccess\Application\UseCase\User\Query;

class GetUserQuery
{
    public ?string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}