<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Repository\Orm;


use App\IdentityAndAccess\Application\UseCase\Query\GetUserListQuery;
use App\IdentityAndAccess\Domain\Entity\User as DomainUser;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\User as DoctrineUser;
use App\IdentityAndAccess\Presentation\Service\Manager\ManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Uid\Uuid;

/**
 * Description: UserOrmRepository.php
 *
 * @author digit <dev@web-symphonie.com>
 * @date 30/12/2024
 *
 * @extends ServiceEntityRepository<DoctrineUser>
 */
class UserOrmRepository extends ServiceEntityRepository implements UserRepositoryInterface, PasswordUpgraderInterface
{
    public function __construct(
        ManagerRegistry                   $registry,
        private readonly ManagerInterface $manager,
    )
    {
        parent::__construct($registry, DoctrineUser::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof DoctrineUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function getByEmail(string $email): ?DomainUser
    {
        try {
            /** @var DoctrineUser $result */
            $result = $this->createQueryBuilder('u')
                ->where('u.email = :email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getOneOrNullResult();
            if (!$result) {
                return null;
            }

            return $this->setUserToDomain($result);
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    private function setUserToDomain(DoctrineUser $result): DomainUser
    {
        return new DomainUser(
            organization: $result->getOrganization(),
            name: $result->getName(),
            email: $result->getEmail(),
            password: $result->getPassword(),
            phone_number: $result->getPhone(),
            address: $result->getAddress(),
            is_enabled: $result->getEnabled(),
            id: $result->getId(),
            roles: $result->getRoles(),
        );
    }

    public function add(DomainUser $user): void
    {
        $doctrineUser = $this->setDomainToUser($user);
        $this->manager->setEntity($doctrineUser, "new");
    }

    private function setDomainToUser(DomainUser $result): DoctrineUser
    {
        return (new DoctrineUser())
            ->setOrganization($result->getOrganization())
            ->setName($result->getName())
            ->setEmail($result->getEmail())
            ->setPhone($result->getPhoneNumber())
            ->setAddress($result->getAddress())
            ->setPassword($result->getPassword())
            ->setEnabled($result->getIsEnabled())
            ->setRoles($result->getRoles());
    }

    public function update(DomainUser $user): void
    {
        $this->manager->setEntity($this->setDomainToUser($user), "edit");
    }

    public function remove(DomainUser $user): void
    {
        $this->manager->setEntity($this->setDomainToUser($user), "delete");
    }

    public function getByVerifyToken(string $token): ?DomainUser
    {
        /** @var DoctrineUser $result */
        $result = $this->createQueryBuilder('u')
            ->where('u.token = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult();
        return $this->setUserToDomain($result);
    }

    public function getByResetToken(string $token): ?DomainUser
    {
        /** @var DoctrineUser $result */
        $result = $this->createQueryBuilder('u')
            ->where('u.token = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult();
        return $this->setUserToDomain($result);
    }

    /**
     * @param GetUserListQuery $query
     * @return Query
     */
    public function getAll(GetUserListQuery $query): Query
    {
        $qb = $this->createQueryBuilder('u');
        if ($query->userId !== null && Uuid::isValid($query->userId)) {
            $domainUser = $this->getById($query->userId);
            $user = $this->setDomainToUser($domainUser);
            if ($user->isSuperAdmin()) {
                $qb->andWhere('u.roles LIKE :roleAdmin')
                    ->setParameter('roleAdmin', '%ROLE_ADMIN%');
            } elseif ($user->isAdmin()) {
                $qb->join('u.owner', 'owner')
                    ->andWhere('owner.id = :ownerId')
                    ->andWhere('u.roles LIKE :roleUser')
                    ->setParameter('ownerId', $user->getId(), UuidType::NAME)
                    ->setParameter('roleUser', '%ROLE_USER%');
            }
        }

        if ($query->organization !== null) {
            $qb->andWhere("u.organization LIKE :organization")
                ->setParameter('organization', "%$query->organization%");
        }

        if ($query->name !== null) {
            $qb->andWhere("u.name LIKE :name")
                ->setParameter('name', "%$query->name%");
        }

        if ($query->email !== null) {
            $qb->andWhere("u.email = :email")->setParameter('email', $query->email);
        }

        if ($query->limit !== null) {
            $qb->setMaxResults($query->limit);
        }

        return $qb->andWhere('u.roles NOT LIKE :role')
            ->setParameter('role', '%ROLE_SUPER_ADMIN%')
            ->orderBy('u.id', 'DESC')->getQuery();
    }

    public function getById(string $id): ?DomainUser
    {
        /** @var DoctrineUser $result */
        $result = $this->createQueryBuilder('u')
            ->where('u.id = :id')
            ->setParameter('id', $id, UuidType::NAME)
            ->getQuery()
            ->getOneOrNullResult();
        return $result !== null ? $this->setUserToDomain($result) : null;
    }
}