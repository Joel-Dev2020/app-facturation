<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Alert', template: 'shared_kernel/components/commons/alert_component.html.twig')]
class AlertComponents
{
    public ?string $title = null;
    public ?string $type = 'info';
    public string $message;
}