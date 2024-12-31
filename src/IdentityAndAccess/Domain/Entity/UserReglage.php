<?php

namespace App\IdentityAndAccess\Domain\Entity;


use App\IdentityAndAccess\Domain\Entity\Trait\DateTrait;

class UserReglage
{
    use DateTrait;

    public ?string $id;
    public ?int $tva;
    public ?bool $isDiscount;
    public ?string $prefixNumeroInvoice;

    /**
     * @param string|null $id
     * @param int|null $tva
     * @param bool|null $isDiscount
     * @param string|null $prefixNumeroInvoice
     */
    public function __construct(
        ?string $id = null,
        ?int    $tva = 18,
        ?bool   $isDiscount = true,
        ?string $prefixNumeroInvoice = null,
    )
    {
        $this->id = $id;
        $this->tva = $tva;
        $this->isDiscount = $isDiscount;
        $this->prefixNumeroInvoice = $prefixNumeroInvoice;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTva(): ?int
    {
        return $this->tva;
    }

    public function getIsDiscount(): ?bool
    {
        return $this->isDiscount;
    }

    public function getPrefixNumeroInvoice(): ?string
    {
        return $this->prefixNumeroInvoice;
    }
}