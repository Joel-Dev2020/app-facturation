<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Service\User;

use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

readonly class UserPermissionsService implements UserPermissionsInterface
{
    public function __construct(
        private UserRolesInterface     $userRoles,
        private RoleHierarchyInterface $roleHierarchy,
    )
    {
    }

    public function isSuperAdmin(User $user): bool
    {
        return $this->userRoles->isSuperAdmin($this->getUserReachableRoles($user));
    }

    private function getUserReachableRoles(User $user): array
    {
        return $this->roleHierarchy->getReachableRoleNames($user->getRoles());
    }

    // Autres vérifications d'accès selon les rôles

    public function isStandard(User $user): bool
    {
        return $this->userRoles->isStandard($this->getUserReachableRoles($user));
    }

    public function canList(User $user): bool
    {
        return $this->userRoles->canList($this->getUserReachableRoles($user));
    }

    public function canCreate(User $user): bool
    {
        return $this->userRoles->canCreate($this->getUserReachableRoles($user));
    }

    // Vérifications d'accès pour chaque permission
    public function canView(User $user): bool
    {
        return $this->userRoles->canView($this->getUserReachableRoles($user));
    }

    public function canEdit(User $user): bool
    {
        return $this->userRoles->canEdit($this->getUserReachableRoles($user));
    }

    public function canDelete(User $user): bool
    {
        return $this->userRoles->canDelete($this->getUserReachableRoles($user));
    }

    public function checkIsPremium(User $user): RedirectResponse|null
    {
        /*if (!$this->isPremium($user->isAdmin() ? $user : $user->getOwner())) {
            return new RedirectResponse($this->router->generate('app_admin'));
        }*/
        return null;
    }

    public function isPremium(User $user): bool
    {
        return $this->userRoles->isPremium($this->getUserReachableRoles($user));
    }

    public function isAdmin(User $user): bool
    {
        return $this->userRoles->isAdmin($this->getUserReachableRoles($user));
    }
}