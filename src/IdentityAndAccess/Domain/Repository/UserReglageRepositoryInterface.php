<?php

namespace App\IdentityAndAccess\Domain\Repository;

use App\IdentityAndAccess\Domain\Entity\UserReglage;

interface UserReglageRepositoryInterface
{
    public function update(UserReglage $reglage);

    public function findOne(string $id);
}