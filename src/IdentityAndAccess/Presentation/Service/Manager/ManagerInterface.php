<?php declare(strict_types=1);

namespace App\Service\Manager;

namespace App\IdentityAndAccess\Presentation\Service\Manager;

interface ManagerInterface
{
    /**
     * Persite les données entité dans la base de données (Entity)
     * Persite les données logs dans la base de données (Logs)
     *
     * @param object $entity
     * @param string $action
     *
     * @return void
     */
    public function setEntity(object $entity, string $action): void;
}