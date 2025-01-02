<?php

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Repository\Orm;


use App\IdentityAndAccess\Application\UseCase\User\Query\GetUserListQuery;
use App\IdentityAndAccess\Domain\Entity\User as DomainUser;
use App\IdentityAndAccess\Domain\Repository\UserRepositoryInterface;
use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\User as DoctrineUser;
use App\IdentityAndAccess\Infrastructure\Mapper\UserMapper;
use App\IdentityAndAccess\Presentation\Service\Manager\ManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
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

            return UserMapper::toDomain($result);
        } catch (NonUniqueResultException) {
            return null;
        }
    }

    public function add(DomainUser $user): ?DomainUser
    {
        $doctrineUser = UserMapper::toInfrastructure($user);
        $this->manager->setEntity($doctrineUser, "new");
        return $doctrineUser->getId() ? UserMapper::toDomain($doctrineUser) : null;
    }

    /**
     * @throws Exception
     */
    public function update(DomainUser $user): ?DomainUser
    {
        // Récupérez l'entité Doctrine existante
        $doctrineUser = $this->getEntityManager()->getRepository(DoctrineUser::class)->find($user->id);

        if (!$doctrineUser) {
            throw new Exception('Utilisateur non trouvé.');
        }

        // Mettez à jour l'entité Doctrine avec les données du domaine
        $doctrineUser = UserMapper::toInfrastructure($user, $doctrineUser);

        // Persist et flush
        $this->manager->setEntity($doctrineUser, "edit");
        return $doctrineUser->getId() ? UserMapper::toDomain($doctrineUser) : null;
    }

    /**
     * @throws Exception
     */
    public function remove(DomainUser $user): void
    {
        // Récupérez l'entité Doctrine existante
        $doctrineUser = $this->getEntityManager()->getRepository(DoctrineUser::class)->find($user->id);

        if (!$doctrineUser) {
            throw new Exception('Utilisateur non trouvé.');
        }

        // Mettez à jour l'entité Doctrine avec les données du domaine
        $doctrineUser = UserMapper::toInfrastructure($user, $doctrineUser);
        $this->manager->setEntity($doctrineUser, "delete");
    }

    public function getByResetToken(string $token): ?DomainUser
    {
        /** @var DoctrineUser $result */
        $result = $this->createQueryBuilder('u')
            ->where('u.passwordResetToken = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult();
        return $result !== null ? UserMapper::toDomain($result) : null;
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
            $user = UserMapper::toInfrastructure($domainUser);
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
        return $result !== null ? UserMapper::toDomain($result) : null;
    }
}