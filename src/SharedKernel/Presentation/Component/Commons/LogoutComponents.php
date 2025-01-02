<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('LogoutComponent', template: 'shared_kernel/components/commons/logout_component.html.twig')]
class LogoutComponents
{
    public string $title;
}