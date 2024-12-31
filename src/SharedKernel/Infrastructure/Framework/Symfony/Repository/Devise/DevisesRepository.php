<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Repository\Devise;

use App\SharedKernel\Domain\Model\Repository\Devise\DeviseRepositoryInterface;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Devise\Devise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Devise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Devise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Devise[]    findAll()
 * @method Devise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisesRepository extends ServiceEntityRepository implements DeviseRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Devise::class);
    }

    /**
     * @param $currency
     * @return float|int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function findCurrency($currency): mixed
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :currency')
            ->setParameter(':currency', $currency)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
