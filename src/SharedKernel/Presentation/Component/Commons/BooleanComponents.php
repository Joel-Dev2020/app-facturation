<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('BooleanComponent', template: 'shared_kernel/components/commons/boolean_component.html.twig')]
class BooleanComponents
{
    public bool $action = false;
    public ?string $labelTrue = 'Oui';
    public ?string $labelFalse = 'Non';
}