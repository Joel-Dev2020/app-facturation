<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use DateTimeImmutable;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('DateComponent', template: 'shared_kernel/components/commons/date_component.html.twig')]
class DateComponents
{
    public ?DateTimeImmutable $date = null;
    public ?string $format = "short";
    public ?string $icon = 'bx bx-calendar';
    public ?string $formatTime = "none";
}