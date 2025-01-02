<?php

namespace App\IdentityAndAccess\Infrastructure\Mapper;

use App\IdentityAndAccess\Domain\Entity\User as DomainUser;
use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\User as DoctrineUser;

class UserMapper
{
    public static function toInfrastructure(DomainUser $domainUser, DoctrineUser $doctrineUser = null): DoctrineUser
    {
        // Si l'entité Doctrine existe déjà, réutilisez-la, sinon créez-en une nouvelle.
        $doctrineUser = $doctrineUser ?? new DoctrineUser();

        return $doctrineUser
            ->setOrganization($domainUser->getOrganization())
            ->setName($domainUser->getName())
            ->setEmail($domainUser->getEmail())
            ->setPhone($domainUser->getPhoneNumber())
            ->setAddress($domainUser->getAddress())
            ->setPassword($domainUser->getPassword())
            ->setPasswordResetToken($domainUser->getPasswordResetToken())
            ->setPasswordResetRequestedAt($domainUser->getPasswordResetRequestedAt())
            ->setPasswordResetExpiresAt($domainUser->getPasswordResetExpiresAt())
            ->setEnabled($domainUser->getIsEnabled())
            ->setIsFree($domainUser->getIsFree())
            ->setRoles($domainUser->getRoles());
    }

    public static function toDomain(DoctrineUser $doctrineUser): DomainUser
    {
        return new DomainUser(
            organization: $doctrineUser->getOrganization(),
            name: $doctrineUser->getName(),
            email: $doctrineUser->getEmail(),
            password: $doctrineUser->getPassword(),
            passwordResetToken: $doctrineUser->getPasswordResetToken(),
            passwordResetRequestedAt: $doctrineUser->getPasswordResetRequestedAt(),
            passwordResetExpiresAt: $doctrineUser->getPasswordResetExpiresAt(),
            phone_number: $doctrineUser->getPhone(),
            address: $doctrineUser->getAddress(),
            is_enabled: $doctrineUser->getEnabled(),
            is_free: $doctrineUser->getIsFree(),
            id: $doctrineUser->getId(),
            roles: $doctrineUser->getRoles(),
        );
    }
}