<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\Trait;

use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Service\User\UserRolesService;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

trait PermissionsTrait
{

    public function isStandard(): bool
    {
        return UserRolesService::isStandard($this->getRoles());
    }

    public function isPremium(): bool
    {
        return UserRolesService::isPremium($this->getRoles());
    }

    public function canList(): bool
    {
        return UserRolesService::canList($this->getRoles());
    }

    public function canCreate(): bool
    {
        return UserRolesService::canCreate($this->getRoles());
    }

    public function canView(): bool
    {
        return UserRolesService::canView($this->getRoles());
    }

    public function canEdit(): bool
    {
        return UserRolesService::canEdit($this->getRoles());
    }

    public function canDelete(): bool
    {
        return UserRolesService::canDelete($this->getRoles());
    }

    public function getAllRoles(RoleHierarchyInterface $roleHierarchy): array
    {
        return $roleHierarchy->getReachableRoleNames($this->getRoles());
    }
}