<?php
/**
 * Created by PhpStorm.
 * User: ovidi
 * Date: 2017-07-29
 * Time: 11:00
 */

namespace Atm\Money;

use PHPUnit\Framework\TestCase;

class CurrenciesTest extends TestCase
{
    public function test_currencies_rates_usd()
    {
        $c = new Currencies();
        $actual = $c->rates("USD");
        $this->assertEquals(1.1497, $actual);
    }

    public function test_currencies_precisions_usd()
    {
        $c = new Currencies();
        $actual = $c->precision("USD");
        $this->assertEquals(2, $actual);
    }
    //Todo other_currenciess
}
