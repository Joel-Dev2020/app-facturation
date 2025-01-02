<?php

namespace App\SharedKernel\Presentation\Component\Layouts;

use App\SharedKernel\Domain\Entity\Parametre\Parametre;
use App\SharedKernel\Domain\Entity\Reglage\Reglage;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('LogoComponent', template: 'layouts/components/logo_component.html.twig')]
class LogoComponents
{
    public Parametre $param;

    /** @var Reglage[] */
    public array $reglage;
}