<?php

namespace App\IdentityAndAccess\Domain\Entity\Trait;

interface PermissionsInterface
{
    public function canList(mixed $user): bool;

    public function canCreate(mixed $user): bool;

    public function canView(mixed $user): bool;

    public function canEdit(mixed $user): bool;

    public function canDelete(mixed $user): bool;
}