<?php
/**
 * Created by PhpStorm.
 * User: ovidi
 * Date: 2017-07-29
 * Time: 10:53
 */

namespace Atm\Core;

use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function test_legal_client_type()
    {
        $legal = new Client(1, 'legal', 01, '2016-01-01');
        $this->assertEquals('legal', $legal->getClientType());
    }

    public function test_natural_client_type()
    {
        $natural = new Client(2, 'natural', 01, '2016-01-01');
        $this->assertEquals('natural', $natural->getClientType());
    }
}
