<?php

namespace App\IdentityAndAccess\Domain\Entity\Trait;


use App\IdentityAndAccess\Domain\Service\User\UserRolesService;

trait UserRolesTrait
{
    public function getRoleLabel(string $key): ?string
    {
        return UserRolesService::getRoleLabel($key) ?? null;
    }

    public function isSuperAdmin(): bool
    {
        return UserRolesService::isSuperAdmin($this->getRoles());
    }

    public function isAdmin(): bool
    {
        return UserRolesService::isAdmin($this->getRoles());
    }

    public function isUser(): bool
    {
        return UserRolesService::isUser($this->getRoles());
    }

    public function isStandard(): bool
    {
        return UserRolesService::isStandard($this->getRoles());
    }

    public function isPremium(): bool
    {
        return UserRolesService::isPremium($this->getRoles());
    }
}