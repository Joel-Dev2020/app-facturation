<?php

namespace App\SharedKernel\Domain\Port\Helper;

interface TokenGeneratorInterface
{
    public function generateToken(): string;
}