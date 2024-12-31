<?php

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;

trait UidTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\Column(type: UuidType::NAME, length: 255, unique: true)]
    #[ORM\CustomIdGenerator('doctrine.uuid_generator')]
    private ?string $id;

    public function getId(): ?string
    {
        return $this->id;
    }
}