<?php

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Port\Helper;

use App\SharedKernel\Domain\Port\Helper\TokenGeneratorInterface;
use Symfony\Component\Uid\Uuid;

class UuidTokenGenerator implements TokenGeneratorInterface
{

    /**
     * @return string
     */
    public function generateToken(): string
    {
        return Uuid::v7()->toRfc4122();
    }
}