<?php

namespace App\IdentityAndAccess\Presentation\Components\User;

use App\SharedKernel\Domain\Entity\Reglage\Reglage;
use App\SharedKernel\Domain\Service\Context\ContextInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('UserSideBarComponent', template: 'layouts/components/user/user_sidebar_component.html.twig')]
class UserSideBarComponents
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