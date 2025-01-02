<?php

namespace App\SharedKernel\Presentation\Component\Commons;

use App\SharedKernel\Domain\Service\Currency\CurrencyInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('CurrencyToWord', template: 'shared_kernel/components/commons/currency_to_word_component.html.twig')]
class CurrencyToWordComponents
{
    public float $price = 0;
    public ?string $textPrefix = 'Arrêtée la présente facture à la somme de:';
    public ?string $devise = 'XOF';

    public function __construct(private readonly CurrencyInterface $currencyInterfaces)
    {
    }

    public function getToCurrency(): string
    {
        return $this->currencyInterfaces->tocurrency($this->price, $this->devise);
    }
}