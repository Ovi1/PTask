<?php
/**
 * Created by PhpStorm.
 * User: ovidi
 * Date: 2017-07-29
 * Time: 10:59
 */

namespace Atm\Helpers;

use PHPUnit\Framework\TestCase;

class MoneyHelperTest extends TestCase
{
    public function test_money_helper_round_up_function(): void
    {
        $money_helper = new MoneyHelper;
        $actual = $money_helper::roundUp(1.99, 1);
        $this->assertEquals(2.0, $actual);
    }
}
