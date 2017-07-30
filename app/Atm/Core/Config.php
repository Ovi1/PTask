<?php
/**
 * Created by PhpStorm.
 * User: ovidi
 * Date: 2017-07-29
 * Time: 16:42
 */

namespace Atm\Core;


class Config
{
    public function __construct()
    {
        define('DEFAULT_CURRENCY', (string)"EUR");
        define('CASH_IN_FEE', (float)0.03);
        define('CASH_IN_FEE_MAX', (float)5.00);
        define('CASH_OUT_FEE_FOR_NATURAL', (float)0.3);
        define('CASH_OUT_FEE_FOR_LEGAL', (float)0.3);
        define('CASH_OUT_FREE_MAX_AMOUNT', (int)1000);
        define('CASH_OUT_FEE_MIN_FOR_LEGAL', (float)0.50);
        define('CASH_OUT_FEE_DISCOUNT_TIMES_NATURAL', (int)3);
    }
}