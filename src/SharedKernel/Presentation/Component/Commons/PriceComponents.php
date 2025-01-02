<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use App\SharedKernel\Domain\Entity\Devise\Devise;
use App\SharedKernel\Domain\Service\Currency\CurrencyInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('PriceComponent', template: 'shared_kernel/components/commons/price_component.html.twig')]
class PriceComponents
{
    public float|int $price = 0;

    public bool $useDevise = true;

    public function __construct(private readonly CurrencyInterface $currencyInterface)
    {
    }

    public function getDevise(): ?Devise
    {
        return $this->currencyInterface->getDevise();
    }

    public function getConvertPrice(): float|int
    {
        return $this->currencyInterface->getPriceForDevise($this->price) ?? 0;
    }
}