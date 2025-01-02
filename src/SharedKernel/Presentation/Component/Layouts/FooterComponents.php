<?php

namespace App\SharedKernel\Presentation\Component\Layouts;

use App\SharedKernel\Domain\Entity\Parametre\Parametre;
use App\SharedKernel\Domain\Entity\Reglage\Reglage;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('FooterComponent', template: 'layouts/components/footer_component.html.twig')]
class FooterComponents
{
    public Parametre $param;

    /** @var Reglage[] */
    public array $reglage;
}