<?php declare(strict_types=1);


namespace App\IdentityAndAccess\Presentation\Service\Manager;

use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

class ManagerService implements ManagerInterface
{
    const ACTION_NEW = 'new';
    const ACTION_EDIT = 'edit';
    const ACTION_DELETE = 'delete';

    private const ACTIONS = [
        self::ACTION_NEW,
        self::ACTION_EDIT,
        self::ACTION_DELETE,
    ];

    public function __construct(private readonly EntityManagerInterface $em, private readonly LoggerInterface $logger)
    {
    }

    public function setEntity(object $entity, string $action): void
    {
        if (!in_array($action, self::ACTIONS, true)) {
            throw new InvalidArgumentException(sprintf("Action '%s' is not valid.", $action));
        }

        switch ($action) {
            case self::ACTION_NEW:
                $this->persistEntity($entity);
                break;
            case self::ACTION_EDIT:
                $this->updateEntity($entity);
                break;
            case self::ACTION_DELETE:
                $this->removeEntity($entity);
                break;
        }

        $this->em->flush();
    }

    private function persistEntity(object $entity): void
    {
        $this->em->persist($entity);
        $this->logger->info("Entity persisted", ['entity' => get_class($entity)]); // Optional logging
    }

    private function updateEntity(object $entity): void
    {
        // Here, we're assuming the entity is already managed, so we only need to flush.
        if ($entity) {
            $this->logger->info("Entity updated", ['entity' => get_class($entity)]); // Optional logging
        }
    }

    private function removeEntity(object $entity): void
    {
        $this->em->remove($entity);
        $this->logger->info("Entity removed", ['entity' => get_class($entity)]); // Optional logging
    }
}