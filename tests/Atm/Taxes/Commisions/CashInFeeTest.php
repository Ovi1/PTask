<?php
/**
 * Created by PhpStorm.
 * User: ovidi
 * Date: 2017-07-29
 * Time: 11:00
 */

namespace Atm\Taxes;

use Atm\Taxes\Commissions\CashInFee;
use PHPUnit\Framework\TestCase;

class CashInFeeTest extends TestCase
{
    public function test_cash_in_fee_max()
    {
        $inFee = new CashInFee();
        $actual = $inFee->cashInFee(999999);
        $this->assertEquals(CASH_IN_FEE_MAX, $actual);
    }

    public function test_cash_in_fee_when_is_less_then_default()
    {
        $inFee = new CashInFee();
        $actual = $inFee->cashInFee(100);
        $this->assertEquals(0.03, $actual);
    }
}
