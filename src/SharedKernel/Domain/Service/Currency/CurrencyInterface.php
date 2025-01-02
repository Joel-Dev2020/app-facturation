<?php declare(strict_types=1);

namespace App\SharedKernel\Domain\Service\Currency;


use App\SharedKernel\Domain\Entity\Devise\Devise;

interface CurrencyInterface
{
    public function tocurrency(float $amount, ?string $currency = 'XOF'): string;

    public function towords(int|float $amount): string;

    public function getPriceForDevise(float $price): float;

    public function getDevise(): ?Devise;

    public function getDefaultDevise(): ?Devise;

    public function formatCurrency(float $amount, string $currencyCode, string $locale = 'fr_FR'): string;
}