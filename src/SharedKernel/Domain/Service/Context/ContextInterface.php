<?php

namespace App\SharedKernel\Domain\Service\Context;

interface ContextInterface
{
    public function findAll(): array;

    public function findParams(): mixed;

    public function getValue(string $name): mixed;
}