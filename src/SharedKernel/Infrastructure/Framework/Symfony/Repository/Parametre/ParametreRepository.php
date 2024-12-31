<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Repository\Parametre;

use App\SharedKernel\Domain\Model\Repository\Parametre\ParametreRepositoryInterface;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Parametre\Parametre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Parametre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parametre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parametre[]    findAll()
 * @method Parametre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParametreRepository extends ServiceEntityRepository implements ParametreRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parametre::class);
    }

    public function findParam(string $id): ?Parametre
    {
        return $this->createQueryBuilder('p')->getQuery()->getOneOrNullResult();
    }
}
