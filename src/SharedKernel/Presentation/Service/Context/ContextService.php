<?php

declare(strict_types=1);

namespace App\SharedKernel\Presentation\Service\Context;

use App\SharedKernel\Domain\Repository\Parametre\ParametreRepositoryInterface;
use App\SharedKernel\Domain\Repository\Reglage\ReglageRepositoryInterface;
use App\SharedKernel\Domain\Service\Context\ContextInterface;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Parametre\Parametre;
use Symfony\Component\DependencyInjection\ContainerInterface;

readonly class ContextService implements ContextInterface
{
    public function __construct(
        private ReglageRepositoryInterface   $reglagesRepository,
        private ContainerInterface           $container,
        private ParametreRepositoryInterface $parametresRepository,
    )
    {
    }

    public function findAll(): array
    {
        $reglage = $this->reglagesRepository->findALLForTwig();
        if (empty($reglagle)) {
            $reglage['app_title'] = 'INVOICES';
        }
        return $reglage;
    }

    public function getValue(string $name): mixed
    {
        return $this->reglagesRepository->getValue($name);
    }

    /**
     * @return Parametre|null
     */
    public function findParams(): ?Parametre
    {
        $id = $this->container->getParameter('params_id');
        return $this->parametresRepository->findParam($id);
    }
}
