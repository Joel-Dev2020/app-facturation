<?php

namespace App\Service\Constants;

class AppConstantsService
{
    public const MONEY = 'money';
    public const CARTE = 'carte';
    public const VIREMENT = 'virement';
    public const ESPECE = 'espece';

    public const DISPLAY_NUMBER = [
        10 => 10,
        20 => 20,
        50 => 50,
        100 => 100,
    ];

    const PAYMENTMETHODS = [
        self::MONEY => 'Mobile money',
        self::CARTE => 'Carte bancaire',
        self::VIREMENT => 'Virement',
        self::ESPECE => 'Espèce',
    ];

    // Mois en français
    public const MONTHS_FRENCH = [
        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
        5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
        9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre',
    ];

    /**
     * @return array
     */
    public static function getTypePaymentMethodsChoices(): array
    {
        $output = [];
        foreach (self::PAYMENTMETHODS as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }

    /**
     * Retourne les mois avec leur numéro.
     */
    public static function getMonths(): array
    {
        $output = [];
        foreach (self::MONTHS_FRENCH as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}