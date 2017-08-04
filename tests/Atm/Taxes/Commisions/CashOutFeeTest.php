<?php
/**
 * Created by PhpStorm.
 * User: ovidi
 * Date: 2017-07-29
 * Time: 11:00
 */

namespace Atm\Taxes;

use Atm\Taxes\Commissions\CashOutFee;
use Atm\Core\Client;
use PHPUnit\Framework\TestCase;

class CashOutFeeTest extends TestCase
{

    public function test_cash_out_fee_when_is_less_then_min_for_legal()
    {
        $outFee = new CashOutFee();
        $client = new Client('1', 'legal');
        $actual = $outFee->cashOutFee(150, $client->getClientType());
        $this->assertEquals(CASH_OUT_FEE_MIN_FOR_LEGAL, $actual);
    }

    public function test_cash_out_fee_when_is_more_then_min_for_legal()
    {
        $outFee = new CashOutFee();
        $client = new Client('2', 'legal');
        $actual = $outFee->cashOutFee(10000, $client->getClientType());
        $this->assertEquals(30, $actual);
    }
    public function test_cash_out_fee_when_is_less_then_min_for_natural()
    {
        $outFee = new CashOutFee();
        $client = new Client('1', 'natural');
        $actual = $outFee->cashOutFee(100, $client->getClientType());
        $this->assertEquals(0.3, $actual);
    }

    public function test_cash_out_fee_when_is_more_then_min_for_natural()
    {
        $outFee = new CashOutFee();
        $client = new Client('2', 'natural');
        $actual = $outFee->cashOutFee(100, $client->getClientType());
        $this->assertEquals(0.3, $actual);
    }
}
