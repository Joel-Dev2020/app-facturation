<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Repository\Reglage;

use App\SharedKernel\Domain\Entity\Reglage\Reglage;
use App\SharedKernel\Domain\Repository\Reglage\ReglageRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reglage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reglage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reglage[]    findAll()
 * @method Reglage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReglageRepository extends ServiceEntityRepository implements ReglageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reglage::class);
    }

    /**
     * @return Reglage[]
     */
    public function findALLForTwig(): array
    {
        return $this->createQueryBuilder('r', 'r.name')
            ->getQuery()
            ->getResult();
    }

    public function getValue(string $name): mixed
    {
        try {
            return $this->createQueryBuilder('r')
                ->select('r.value')
                ->where('r.name = :name')
                ->setParameter('name', $name)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException|NonUniqueResultException) {
            return null;
        }
    }
}
