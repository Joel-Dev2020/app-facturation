<?php

namespace App\IdentityAndAccess\Domain\Entity;


use App\IdentityAndAccess\Domain\Entity\Trait\DateTrait;
use App\SharedKernel\Domain\Entity\Devise\Devise;

class UserReglage
{
    use DateTrait;

    public ?string $id;
    public ?int $tva;
    public ?bool $isDiscount;
    public ?string $prefixNumeroInvoice;
    public ?User $user;
    public ?Devise $devises;

    public function __construct(
        ?string $id = null,
        ?int    $tva = 18,
        ?bool   $isDiscount = true,
        ?string $prefixNumeroInvoice = null,
        ?User   $user = null,
        ?Devise $devises = null
    )
    {
        $this->id = $id;
        $this->tva = $tva;
        $this->isDiscount = $isDiscount;
        $this->prefixNumeroInvoice = $prefixNumeroInvoice;
        $this->user = $user;
        $this->devises = $devises;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTva(): ?int
    {
        return $this->tva;
    }

    public function setTva(?int $tva): UserReglage
    {
        $this->tva = $tva;
        return $this;
    }

    public function getIsDiscount(): ?bool
    {
        return $this->isDiscount;
    }

    public function setIsDiscount(?bool $isDiscount): UserReglage
    {
        $this->isDiscount = $isDiscount;
        return $this;
    }

    public function getPrefixNumeroInvoice(): ?string
    {
        return $this->prefixNumeroInvoice;
    }

    public function setPrefixNumeroInvoice(?string $prefixNumeroInvoice): UserReglage
    {
        $this->prefixNumeroInvoice = $prefixNumeroInvoice;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): UserReglage
    {
        $this->user = $user;
        return $this;
    }

    public function getDevises(): ?Devise
    {
        return $this->devises;
    }

    public function setDevises(?Devise $devises): UserReglage
    {
        $this->devises = $devises;
        return $this;
    }
}