<?php

namespace App\IdentityAndAccess\Domain\Service\User;

use App\IdentityAndAccess\Domain\Entity\Trait\UserRolesInterface;

class UserRolesService implements UserRolesInterface
{
    public static function getRoleLabel(string $role): ?string
    {
        return UserConstants::ROLE_LABELS[$role] ?? null;
    }

    public static function getBadgeClass(string $role): ?string
    {
        return UserConstants::BADGES[$role] ?? 'secondary';
    }

    public static function getPrimaryRoles(): array
    {
        return [
            'Manager' => UserConstants::ROLE_ADMIN,
        ];
    }

    public static function getAdminListRoles(): array
    {
        return [
            'Commerçial' => UserConstants::ROLE_USER,
        ];
    }

    public static function getRoles(): array
    {
        return array_flip(UserConstants::ROLE_LABELS);
    }

    public static function getPermissions(): array
    {
        return array_flip(UserConstants::ROLE_LABELS);
    }

    public static function isSuperAdmin(array $roles): bool
    {
        return self::hasRole($roles, UserConstants::ROLE_SUPER_ADMIN);
    }

    // Vérifications dynamiques des rôles par le rôle cible

    public static function hasRole(array $roles, string $role): bool
    {
        return in_array($role, $roles, true);
    }

    public static function isAdmin(array $roles): bool
    {
        return self::hasRole($roles, UserConstants::ROLE_ADMIN);
    }

    public static function isUser(array $roles): bool
    {
        return self::hasRole($roles, UserConstants::ROLE_USER);
    }

    public static function isStandard(array $roles): bool
    {
        return self::hasRole($roles, UserConstants::ROLE_STANDARD);
    }

    public static function isPremium(array $roles): bool
    {
        return self::hasRole($roles, UserConstants::ROLE_PREMIUM);
    }

    // Vérifications d'accès pour chaque permission
    public static function canList(array $roles): bool
    {
        return self::hasRole($roles, UserConstants::ROLE_LIST);
    }

    public static function canCreate(array $roles): bool
    {
        return self::hasRole($roles, UserConstants::ROLE_CREATE);
    }

    public static function canView(array $roles): bool
    {
        return self::hasRole($roles, UserConstants::ROLE_VIEW);
    }

    public static function canEdit(array $roles): bool
    {
        return self::hasRole($roles, UserConstants::ROLE_EDIT);
    }

    public static function canDelete(array $roles): bool
    {
        return self::hasRole($roles, UserConstants::ROLE_DELETE);
    }
}
