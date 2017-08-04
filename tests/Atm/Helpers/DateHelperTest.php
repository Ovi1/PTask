<?php
/**
 * Created by PhpStorm.
 * User: ovidi
 * Date: 2017-07-29
 * Time: 10:59
 */

namespace Atm\Helpers;

use PHPUnit\Framework\TestCase;

class DateHelperTest extends TestCase
{
    public function test_date_week_for_given_date(): void
    {
        $date_helper = new DateHelper;
        $actual = $date_helper::dateToWeekNumber('2016-01-01');
        $this->assertEquals('53', $actual);
    }
}
