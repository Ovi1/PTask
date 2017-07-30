<?php

/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-05
 * Time: 11:20
 * Default exchange rates EUR:USD - 1:1.1497, EUR:JPY - 1:129.53
 */

namespace Atm\Money;

use Exception;

class Currencies
{
    private $default_currency = DEFAULT_CURRENCY;

    /**
     * @param $amount
     * @param $currency
     * @return float
     */
    public function exchange($amount, $currency)
    {
        if (strtoupper($currency) != $this->getDefaultCurrency()) {
            $rate = $this->rates($currency);
            $exchange_amount = $amount / $rate;
        } else {
            $exchange_amount = $amount;
        }
        return $exchange_amount;
    }


    /**
     * @param $currency
     * @return float|int
     * @throws Exception
     */
    public function rates($currency)
    {
        switch (strtoupper($currency)) {
            case $this->getDefaultCurrency():
                $rate = 1;
                break;
            case "USD":
                $rate = 1.1497;
                break;
            case "JPY":
                $rate = 129.53;
                break;
            default:
                throw new Exception('Invalid Currency');
        }
        return $rate;
    }


    /**
     * @param $currency
     * @return int
     * @throws Exception
     */
    public function precision($currency)
    {
        switch (strtoupper($currency)) {
            case $this->getDefaultCurrency():
                $precision = 2;
                break;
            case "USD":
                $precision = 2;
                break;
            case "JPY":
                $precision = 1;
                break;
            default:
                throw new Exception('Invalid Currency');
        }
        return $precision;
    }
    /**
     * @return string
     */
    public function getDefaultCurrency(): string
    {
        return $this->default_currency;
    }

}