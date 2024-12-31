<?php

namespace App\SharedKernel\Domain\Repository\Parametre;


use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Parametre\Parametre;

interface ParametreRepositoryInterface
{
    public function findParam(string $id): ?Parametre;
}