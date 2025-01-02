<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('EmptyComponent', template: 'shared_kernel/components/commons/empty_component.html.twig')]
class EmptyComponents
{
    public ?string $message = 'Rien à voir pour le moment...';
}