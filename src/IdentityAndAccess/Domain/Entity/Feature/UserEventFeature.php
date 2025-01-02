<?php

namespace App\IdentityAndAccess\Domain\Entity\Feature;

use App\SharedKernel\Domain\Common\Event\DomainEventInterface;

trait UserEventFeature
{
    private array $domainEvents = [];

    public function emitEvent(DomainEventInterface $event): void
    {
        $this->domainEvents[] = $event;
    }

    public function pullDomainEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = []; // Réinitialisation après récupération
        return $events;
    }
}