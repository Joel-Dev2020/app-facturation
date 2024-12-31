<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Service\User;


use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\User;

interface UserPermissionsInterface
{
    public function isSuperAdmin(User $user): bool;

    public function isStandard(User $user): bool;

    public function canList(User $user): bool;

    public function canCreate(User $user): bool;

    public function canView(User $user): bool;

    public function canEdit(User $user): bool;

    public function canDelete(User $user): bool;

    public function isPremium(User $user): bool;

    public function isAdmin(User $user): bool;
}