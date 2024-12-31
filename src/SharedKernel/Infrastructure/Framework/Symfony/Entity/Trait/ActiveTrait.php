<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait;


use Doctrine\ORM\Mapping as ORM;

trait ActiveTrait
{
    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private ?bool $is_active = false;

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }
}
