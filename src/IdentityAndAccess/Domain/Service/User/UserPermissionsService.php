<?php

namespace App\IdentityAndAccess\Domain\Service\User;

use App\IdentityAndAccess\Domain\Entity\Trait\PermissionsInterface;
use App\IdentityAndAccess\Domain\Entity\Trait\UserRolesInterface;

readonly class UserPermissionsService implements PermissionsInterface
{
    public function __construct(private UserRolesInterface $userRoles, private RoleHierarchyServiceInterface $roleHierarchy)
    {
    }

    public function canList(mixed $user): bool
    {
        return $this->userRoles->canList($this->getUserReachableRoles($user));
    }

    private function getUserReachableRoles(mixed $user): array
    {
        return $this->roleHierarchy->getReachableRoles($user->getRoles());
    }

    public function canView(mixed $user): bool
    {
        return $this->userRoles->canView($this->getUserReachableRoles($user));
    }

    public function canCreate(mixed $user): bool
    {
        return $this->userRoles->canCreate($this->getUserReachableRoles($user));
    }

    public function canEdit(mixed $user): bool
    {
        return $this->userRoles->canEdit($this->getUserReachableRoles($user));
    }

    public function canDelete(mixed $user): bool
    {
        return $this->userRoles->canDelete($this->getUserReachableRoles($user));
    }
}