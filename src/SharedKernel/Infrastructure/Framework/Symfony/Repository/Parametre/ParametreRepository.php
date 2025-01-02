<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Repository\Parametre;

use App\SharedKernel\Domain\Entity\Parametre\Parametre as DomainParametre;
use App\SharedKernel\Domain\Repository\Parametre\ParametreRepositoryInterface;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Parametre\Parametre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Types\UuidType;

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

    public function findParam(string $id): ?DomainParametre
    {
        $result = $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id, UuidType::NAME)
            ->getQuery()
            ->getOneOrNullResult();
        return $this->setParametreToDomain($result);
    }

    private function setParametreToDomain(Parametre $result): DomainParametre
    {
        return new DomainParametre(
            id: $result->getId(),
            filename: $result->getFilename(),
            filename2: $result->getFilename2(),
            icon: $result->getIcon(),
            imageFile: $result->getImageFile(),
            imageFile2: $result->getImageFile2(),
            iconFile: $result->getIconFile(),
        );
    }
}
