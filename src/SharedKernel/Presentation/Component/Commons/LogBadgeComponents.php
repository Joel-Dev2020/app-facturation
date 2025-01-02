<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use App\SharedKernel\Domain\Entity\Notification\Notification;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('LogBadgeComponent', template: 'shared_kernel/components/commons/log_badge_component.html.twig')]
class LogBadgeComponents
{
    public Notification $notification;
}