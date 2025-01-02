<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('StatusBadgeComponent', template: 'shared_kernel/components/commons/status_badge_component.html.twig')]
class StatusBadgeComponents
{
    public int $status = 0;
    public ?string $statusValue = null;
}