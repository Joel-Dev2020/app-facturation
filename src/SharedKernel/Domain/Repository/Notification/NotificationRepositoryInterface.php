<?php

namespace App\SharedKernel\Domain\Repository\Notification;

interface NotificationRepositoryInterface
{
    public function countNotifs(mixed $user): int;

    public function getUnreadNotifs(mixed $user): ?array;
}