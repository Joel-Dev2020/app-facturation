<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use DateTimeImmutable;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('DateProgressBarComponent', template: 'shared_kernel/components/commons/date_progress_bar_component.html.twig')]
class DateProgressBarComponents
{
    public DateTimeImmutable $start;
    public DateTimeImmutable $end;
    public bool $displayLabel = true;

    public function generateProgressBar(): int
    {
        $now = new DateTimeImmutable();
        $totalDuration = $this->end->getTimestamp() - $this->start->getTimestamp();
        $elapsedDuration = $now->getTimestamp() - $this->start->getTimestamp();
        return ($totalDuration > 0) ? min(100, max(0, ($elapsedDuration / $totalDuration) * 100)) : 0;
    }
}