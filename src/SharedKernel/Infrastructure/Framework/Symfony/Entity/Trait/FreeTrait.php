<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait FreeTrait
{
    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private ?bool $is_free = false;

    public function getIsFree(): ?bool
    {
        return $this->is_free;
    }

    public function setIsFree(bool $is_free): self
    {
        $this->is_free = $is_free;

        return $this;
    }
}
