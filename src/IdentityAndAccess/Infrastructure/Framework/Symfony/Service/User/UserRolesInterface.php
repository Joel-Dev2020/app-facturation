<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Service\User;

interface UserRolesInterface
{
    public static function getBadgeClass(string $role): ?string;

    public static function getPrimaryRoles(): array;

    public static function getAdminListRoles(): array;

    public static function getRoles(): array;

    public static function getPermissions(): array;

    public static function isSuperAdmin(array $roles): bool;

    public static function hasRole(array $roles, string $role): bool;

    public static function isAdmin(array $roles): bool;

    public static function isUser(array $roles): bool;

    public static function isStandard(array $roles): bool;

    public static function isPremium(array $roles): bool;

    // Vérifications d'accès pour chaque permission
    public static function canList(array $roles): bool;

    public static function canCreate(array $roles): bool;

    public static function canView(array $roles): bool;

    public static function canEdit(array $roles): bool;

    public static function canDelete(array $roles): bool;
}