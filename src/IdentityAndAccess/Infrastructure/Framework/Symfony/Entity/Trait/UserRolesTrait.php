<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\Trait;


use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Service\User\UserRolesService;

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
}