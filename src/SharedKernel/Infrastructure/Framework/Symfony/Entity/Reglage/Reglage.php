<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Reglage;

use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\DatesTrait;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\UidTrait;
use App\SharedKernel\Infrastructure\Framework\Symfony\Repository\Reglage\ReglageRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ReglageRepository::class)]
#[ORM\Table(name: "reglages")]
class Reglage
{
    use UidTrait;
    use DatesTrait;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $label;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $value;

    #[ORM\Column(type: 'text')]
    private string $type;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Reglage
    {
        $this->name = $name;
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): Reglage
    {
        $this->label = $label;
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): Reglage
    {
        $this->value = $value;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Reglage
    {
        $this->type = $type;
        return $this;
    }

    public function __toString(): string
    {
        return $this->value ?? '';
    }

}
