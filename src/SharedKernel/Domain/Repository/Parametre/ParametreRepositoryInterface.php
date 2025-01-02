<?php

namespace App\SharedKernel\Domain\Repository\Parametre;


use App\SharedKernel\Domain\Entity\Parametre\Parametre;

interface ParametreRepositoryInterface
{
    public function findParam(string $id): ?Parametre;
}