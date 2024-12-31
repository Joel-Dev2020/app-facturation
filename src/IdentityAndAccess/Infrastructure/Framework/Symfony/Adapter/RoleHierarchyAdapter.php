<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Adapter;

use App\IdentityAndAccess\Domain\Service\User\RoleHierarchyServiceInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class RoleHierarchyAdapter implements RoleHierarchyServiceInterface
{
    private RoleHierarchyInterface $roleHierarchy;

    public function __construct(RoleHierarchyInterface $roleHierarchy)
    {
        $this->roleHierarchy = $roleHierarchy;
    }

    public function getReachableRoles(array $roles): array
    {
        return $this->roleHierarchy->getReachableRoleNames($roles);
    }
}