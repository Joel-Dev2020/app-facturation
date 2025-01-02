<?php

namespace App\SharedKernel\Presentation\Component\Layouts;

use App\SharedKernel\Domain\Entity\Parametre\Parametre;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('SideBarComponent', template: 'layouts/components/sidebar_component.html.twig')]
class SideBarComponents
{
    public Parametre $param;
}