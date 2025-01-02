<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Repository\Notification;

use App\SharedKernel\Domain\Entity\Reglage\Reglage;
use App\SharedKernel\Domain\Repository\Notification\NotificationRepositoryInterface;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Notification\Notification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reglage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reglage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reglage[]    findAll()
 * @method Reglage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository implements NotificationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    public function getUnreadNotifs(mixed $user): ?array
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.read_at = FALSE')
            ->orderBy('n.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function countNotifs(mixed $user): int
    {
        $qb = $this->createQueryBuilder('n')
            ->select('COUNT(n.id)')
            ->where('n.read_at = FALSE');
        $result = $qb->getQuery()->getOneOrNullResult();

        return $result !== null ? (int)$result[1] : 0;
    }
}
