<?php

namespace App\SharedKernel\Presentation\Component\Layouts;

use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Security\SecurityUser;
use App\SharedKernel\Domain\Entity\Parametre\Parametre;
use App\SharedKernel\Domain\Entity\Reglage\Reglage;
use App\SharedKernel\Domain\Service\Context\ContextInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('HeaderComponent', template: 'layouts/components/header_component.html.twig')]
class HeaderComponents
{
    public Parametre $param;

    /** @var Reglage[] */
    public array $reglage;

    public function __construct(private readonly ContextInterface $context)
    {
    }

    public function isActiveSub(?SecurityUser $user): ?bool
    {
        return $this->context->isActiveSub();
    }
}