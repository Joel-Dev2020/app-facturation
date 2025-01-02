<?php

namespace App\SharedKernel\Presentation\Service\Currency;

use App\IdentityAndAccess\Domain\Entity\User;
use App\SharedKernel\Domain\Entity\Devise\Devise;
use App\SharedKernel\Domain\Repository\Devise\DeviseRepositoryInterface;
use App\SharedKernel\Domain\Service\Currency\CurrencyInterface;
use InvalidArgumentException;
use NumberToWords\Exception\NumberToWordsException;
use NumberToWords\NumberToWords;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class CurrencyService implements CurrencyInterface
{
    public function __construct(
        private Security                  $security,
        private RequestStack              $requestStack,
        private DeviseRepositoryInterface $deviseRepository
    )
    {
    }

    /**
     * @throws NumberToWordsException
     * @throws \NumberToWords\Exception\InvalidArgumentException
     */
    public function tocurrency(float $amount, ?string $currency = 'XOF'): string
    {
        if (!$currency) {
            return '';
        }
        $montant = 0;
        if ($amount) {
            $montant = $montant + ($amount * 100);
        } else {
            $montant = $montant + $amount;
        }
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();
        $locale = $request->getLocale();
        $numberToWords = new NumberToWords();
        $currencyTransformer = $numberToWords->getCurrencyTransformer($locale);
        return $currencyTransformer->toWords(intval($montant), $currency);
    }

    /**
     * @param int|float $amount
     * @return string
     * @throws InvalidArgumentException
     * @throws NumberToWordsException
     */
    public function towords(int|float $amount): string
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();
        $locale = $request->getLocale();
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer($locale);
        return $numberTransformer->toWords($amount);
    }

    public function getPriceForDevise(float $price): float
    {
        $exchangeRate = $this->getDevise()?->getExchangedValue() ?: 1;
        return $price * $exchangeRate;
    }

    public function getDevise(): ?Devise
    {
        /** @var User $user */
        $user = $this->security->getUser();
        return $user->isAdmin() ? $user->getReglage()?->getDevises() : $user->getOwner()->getReglage()?->getDevises();
    }

    public function getDefaultDevise(): ?Devise
    {
        return $this->deviseRepository->findOneBy(['currencyCode' => 'XOF', 'lang' => 'fr']);
    }

    public function formatCurrency(float $amount, string $currencyCode, string $locale = 'fr_FR'): string
    {
        return $this->formatCurrency($amount, $currencyCode, $locale);
    }
}