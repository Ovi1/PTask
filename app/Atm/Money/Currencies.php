<?php

/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-05
 * Time: 11:20
 * Default exchange rates EUR:USD - 1:1.1497, EUR:JPY - 1:129.53
 */

namespace Atm\Money;

class Currencies
{
    private static $default_currency = "EUR";

    /**
     * @param $amount
     * @param $currency
     *
     * @return float
     */
    public static function exchange($amount, $currency)
    {
        $default_currency = self::getDefaultCurrency();
        if (strtoupper($currency) != $default_currency) {
            $rate            = self::exchangeRates($currency);
            $exchange_amount = $amount * $rate;
        } else {
            $exchange_amount = $amount;
        }

        return self::roundAmount($exchange_amount);
    }

    /**
     * @param $currency
     *
     * @return float|int
     */
    public function exchangeRates($currency)
    {
        switch (strtoupper($currency)) {
            case "USD":
                $rate = 1.1497;
                break;
            case "JPY":
                $rate = 129.53;
                break;
            default:
                $rate = 1;
                break;
        }

        return $rate;
    }

    /**
     * Apvalinimas
     * Paskaičiavus komisinį mokestį, jis apvalinamas mažiausio valiutos vieneto (pvz. EUR valiutai - centų) tikslumu į didžiąją pusę (0.023 EUR apvalinasi į 3 Euro centus).
     * Apvalinimas atliekamas jau po konvertavimo.
     *
     * @param $amount
     *
     * @return float
     */
    public function roundAmount($amount)
    {
        $round = round($amount, 2);

        return $round;
    }

    /**
     * @return string
     */
    public static function getDefaultCurrency(): string
    {
        return self::$default_currency;
    }

    /**
     * @param string $default_currency
     */
    public static function setDefaultCurrency(string $default_currency)
    {
        self::$default_currency = strtoupper($default_currency);
    }
}