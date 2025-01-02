<?php

namespace App\IdentityAndAccess\Presentation\Components\Admin;

use App\SharedKernel\Domain\Entity\Reglage\Reglage;
use App\SharedKernel\Domain\Service\Context\ContextInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('AdminSideBarComponent', template: 'layouts/components/admin/admin_sidebar_component.html.twig')]
class AdminSideBarComponents
{
    /** @var Reglage[] */
    public array $reglage;

    public function __construct(private readonly ContextInterface $context)
    {
    }

    public function isActiveSub(): ?bool
    {
        return $this->context->isActiveSub();
    }
}