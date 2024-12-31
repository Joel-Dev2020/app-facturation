<?php

namespace App\SharedKernel\Domain\Service\Session;

interface FlashInterface
{
    public function success(string $message): void;

    public function info(string $message): void;

    public function warning(string $message): void;

    public function danger(string $message): void;
}