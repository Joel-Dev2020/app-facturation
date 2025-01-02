<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('TotalLabelComponent', template: 'shared_kernel/components/commons/total_label_component.html.twig')]
class TotalLabelComponents
{
    public int $remise = 0;
    public int $tva = 0;
}