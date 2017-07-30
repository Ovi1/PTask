<?php
/**
 * Created by PhpStorm.
 * User: ovidi
 * Date: 2017-07-29
 * Time: 10:53
 */

namespace Atm\Core;

use PHPUnit\Framework\TestCase;

new Config();

class AtmTest extends TestCase
{
    public function test_atm_instance()
    {
//        @TODO write test for Atm;
        $this->assertEquals(true, true);
    }
}
