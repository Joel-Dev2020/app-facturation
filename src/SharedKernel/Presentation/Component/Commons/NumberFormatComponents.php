<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('NumberFormat', template: 'shared_kernel/components/commons/number_format_component.html.twig')]
class NumberFormatComponents
{
    public float|int $number = 0;
    public ?string $unite = null;
}