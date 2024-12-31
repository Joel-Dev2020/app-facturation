<?php

namespace App\SharedKernel\Domain\Repository\Reglage;

interface ReglageRepositoryInterface
{
    public function findALLForTwig(): array;

    public function getValue(string $name): mixed;
}