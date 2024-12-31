<?php

declare(strict_types=1);

namespace App\IdentityAndAccess\Infrastructure\Framework\Symfony\Repository\Orm;

use App\IdentityAndAccess\Domain\Entity\UserReglage as DomainReglage;
use App\IdentityAndAccess\Domain\Repository\UserReglageRepositoryInterface;
use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\UserReglage as DoctrineReglage;
use App\IdentityAndAccess\Presentation\Service\Manager\ManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DoctrineReglage>
 */
class UserOrmReglageRepository extends ServiceEntityRepository implements UserReglageRepositoryInterface
{
    public function __construct(
        ManagerRegistry                         $registry,
        private readonly EntityManagerInterface $em,
        private readonly ManagerInterface       $manager,
    )
    {
        parent::__construct($registry, DoctrineReglage::class);
    }

    /**
     * @param DomainReglage $reglage
     * @return DomainReglage|null
     */
    public function update(DomainReglage $reglage): ?DomainReglage
    {
        /** @var DoctrineReglage $doctrineReglage */
        $doctrineReglage = $this->em->getRepository(DoctrineReglage::class)->find($reglage->getId());
        $doctrineReglage
            ->setTva($reglage->getTva())
            ->setIsDiscount($reglage->getIsDiscount())
            ->setPrefixNumeroInvoice($reglage->getPrefixNumeroInvoice());
        $this->manager->setEntity($doctrineReglage, 'edit');
        return $reglage;
    }

    /**
     * @param string $id
     * @return DoctrineReglage
     */
    public function findOne(string $id): DoctrineReglage
    {
        return $this->em->getRepository(DoctrineReglage::class)->find($id);
    }
}
