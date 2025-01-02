<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Entity\Devise;


use App\IdentityAndAccess\Domain\Entity\Trait\DateTrait;
use App\IdentityAndAccess\Domain\Entity\UserReglage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Devise
{
    use DateTrait;

    public readonly ?string $id;

    private ?string $currencyCode;

    private ?string $currencyName;

    private ?string $leftSymbol;

    private ?string $rightSymbol;

    private ?string $decimalSymbol;

    private ?int $decimalPlace;

    private ?string $thousandsSeparator;

    private ?float $exchangedValue;

    private ?int $codeiso;

    private ?string $lang;

    private ?string $langCode;

    private Collection $reglage;

    public function __construct(
        ?string    $id = null,
        ?string    $currencyCode = null,
        ?string    $currencyName = null,
        ?string    $leftSymbol = null,
        ?string    $rightSymbol = null,
        ?string    $decimalSymbol = null,
        ?int       $decimalPlace = null,
        ?string    $thousandsSeparator = null,
        ?float     $exchangedValue = null,
        ?int       $codeiso = null,
        ?string    $lang = null,
        ?string    $langCode = null,
        Collection $reglage = new ArrayCollection(),
    )
    {
        $this->id = $id;
        $this->currencyCode = $currencyCode;
        $this->currencyName = $currencyName;
        $this->leftSymbol = $leftSymbol;
        $this->rightSymbol = $rightSymbol;
        $this->decimalSymbol = $decimalSymbol;
        $this->decimalPlace = $decimalPlace;
        $this->thousandsSeparator = $thousandsSeparator;
        $this->exchangedValue = $exchangedValue;
        $this->codeiso = $codeiso;
        $this->lang = $lang;
        $this->langCode = $langCode;
        $this->reglage = $reglage;
    }


    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(?string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getLeftSymbol(): ?string
    {
        return $this->leftSymbol;
    }

    public function setLeftSymbol(?string $leftSymbol): self
    {
        $this->leftSymbol = $leftSymbol;

        return $this;
    }

    public function getRightSymbol(): ?string
    {
        return $this->rightSymbol;
    }

    public function setRightSymbol(?string $rightSymbol): self
    {
        $this->rightSymbol = $rightSymbol;

        return $this;
    }

    public function getDecimalSymbol(): ?string
    {
        return $this->decimalSymbol;
    }

    public function setDecimalSymbol(?string $decimalSymbol): self
    {
        $this->decimalSymbol = $decimalSymbol;

        return $this;
    }

    public function getDecimalPlace(): ?int
    {
        return $this->decimalPlace;
    }

    public function setDecimalPlace(?int $decimalPlace): self
    {
        $this->decimalPlace = $decimalPlace;

        return $this;
    }

    public function getThousandsSeparator(): ?string
    {
        return $this->thousandsSeparator;
    }

    public function setThousandsSeparator(?string $thousandsSeparator): self
    {
        $this->thousandsSeparator = $thousandsSeparator;

        return $this;
    }

    public function getExchangedValue(): ?float
    {
        return $this->exchangedValue;
    }

    public function setExchangedValue(?float $exchangedValue): self
    {
        $this->exchangedValue = $exchangedValue;

        return $this;
    }

    public function getCodeiso(): ?int
    {
        return $this->codeiso;
    }

    public function setCodeiso(?int $codeiso): self
    {
        $this->codeiso = $codeiso;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getCurrencyName();
    }

    public function getCurrencyName(): string
    {
        return $this->currencyName;
    }

    public function setCurrencyName(string $currencyName): self
    {
        $this->currencyName = $currencyName;

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(?string $lang): Devise
    {
        $this->lang = $lang;
        return $this;
    }

    public function getLangCode(): ?string
    {
        return $this->langCode;
    }

    public function setLangCode(?string $langCode): Devise
    {
        $this->langCode = $langCode;
        return $this;
    }

    /**
     * @return Collection<int, UserReglage>
     */
    public function getReglages(): Collection
    {
        return $this->reglage;
    }

    public function addReglage(UserReglage $reglage): self
    {
        if (!$this->reglage->contains($reglage)) {
            $this->reglage[] = $reglage;
            $reglage->setDevises($this);
        }

        return $this;
    }

    public function removeReglage(UserReglage $reglage): self
    {
        if ($this->reglage->contains($reglage)) {
            $this->reglage->removeElement($reglage);
            if ($reglage->getDevises() === $this) {
                $reglage->setDevises(null);
            }
        }

        return $this;
    }
}
