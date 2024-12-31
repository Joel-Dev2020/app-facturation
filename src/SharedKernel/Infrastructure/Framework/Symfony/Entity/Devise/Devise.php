<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Devise;

use App\IdentityAndAccess\Infrastructure\Framework\Symfony\Entity\UserReglage;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\ActiveTrait;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\DatesTrait;
use App\SharedKernel\Infrastructure\Framework\Symfony\Entity\Trait\UidTrait;
use App\SharedKernel\Infrastructure\Framework\Symfony\Repository\Devise\DevisesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisesRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: "devises")]
class Devise
{
    use UidTrait;
    use DatesTrait;
    use ActiveTrait;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $currencyCode = null;

    #[ORM\Column(type: 'string', length: 30, nullable: false)]
    private ?string $currencyName = null;

    #[ORM\Column(type: 'string', length: 12, nullable: true)]
    private ?string $leftSymbol = null;

    #[ORM\Column(type: 'string', length: 12, nullable: true)]
    private ?string $rightSymbol = null;

    #[ORM\Column(type: 'string', length: 1, nullable: true)]
    private ?string $decimalSymbol = null;

    #[ORM\Column(type: 'integer', length: 1, nullable: true)]
    private ?int $decimalPlace = null;

    #[ORM\Column(type: 'string', length: 1, nullable: true)]
    private ?string $thousandsSeparator = null;

    #[ORM\Column(type: 'float', precision: 6, nullable: true)]
    private ?float $exchangedValue = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $codeiso = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $lang = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $langCode = null;

    #[ORM\OneToMany(targetEntity: UserReglage::class, mappedBy: 'devises')]
    private Collection $reglage;

    public function __construct()
    {
        $this->reglage = new ArrayCollection();
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
