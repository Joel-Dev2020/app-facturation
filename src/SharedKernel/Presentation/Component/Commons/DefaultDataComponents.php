<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('DefaultDataComponent', template: 'shared_kernel/components/commons/default_data_component.html.twig')]
class DefaultDataComponents
{
    public ?string $label = 'Aucun(e)';
}