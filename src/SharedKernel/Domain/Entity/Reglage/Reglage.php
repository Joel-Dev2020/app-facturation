<?php

namespace App\SharedKernel\Domain\Entity\Reglage;

class Reglage
{
    public readonly ?string $id;
    private ?string $name;
    private ?string $label;
    private ?string $value;

    public function __construct(
        int     $id = null,
        ?string $name = null,
        ?string $label = null,
        ?string $value = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Reglage
    {
        $this->name = $name;
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): Reglage
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
}