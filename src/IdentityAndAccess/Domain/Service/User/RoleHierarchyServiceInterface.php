<?php

namespace App\IdentityAndAccess\Domain\Service\User;

interface RoleHierarchyServiceInterface
{
    public function getReachableRoles(array $roles): array;
}