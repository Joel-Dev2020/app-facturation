<?php

namespace App\SharedKernel\Domain\Common\Event;

use DateTimeImmutable;

/**
 * Interface de base pour tous les événements de domaine.
 */
interface DomainEventInterface
{
    /**
     * Retourne la date et l'heure auxquelles l'événement s'est produit.
     */
    public function getOccurredOn(): DateTimeImmutable;
}