<?php

namespace App\IdentityAndAccess\Domain\Service\User;

class UserConstants
{
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_LIST = 'ROLE_LIST';
    public const ROLE_VIEW = 'ROLE_VIEW';
    public const ROLE_CREATE = 'ROLE_CREATE';
    public const ROLE_EDIT = 'ROLE_EDIT';
    public const ROLE_DELETE = 'ROLE_DELETE';
    public const ROLE_STANDARD = 'ROLE_STANDARD';
    public const ROLE_PREMIUM = 'ROLE_PREMIUM';

    public const ROLE_LABELS = [
        self::ROLE_ADMIN => 'Manager',
        self::ROLE_USER => 'Commerçial',
        self::ROLE_LIST => 'Lecture (Liste)',
        self::ROLE_VIEW => 'Lecture (Détail)',
        self::ROLE_CREATE => 'Création',
        self::ROLE_EDIT => 'Édition',
        self::ROLE_DELETE => 'Suppression',
        self::ROLE_STANDARD => 'Abonnement standard',
        self::ROLE_PREMIUM => 'Abonnement prémium',
    ];

    public const BADGES = [
        self::ROLE_SUPER_ADMIN => 'success',
        self::ROLE_ADMIN => 'info',
        self::ROLE_USER => 'warning',
        self::ROLE_LIST => 'primary',
        self::ROLE_CREATE => 'success',
        self::ROLE_VIEW => 'info',
        self::ROLE_EDIT => 'warning',
        self::ROLE_DELETE => 'danger',
        self::ROLE_STANDARD => 'warning',
        self::ROLE_PREMIUM => 'success',
    ];
}