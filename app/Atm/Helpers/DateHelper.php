<?php
/**
 * Created by PhpStorm.
 * User: ovidi
 * Date: 2017-07-29
 * Time: 10:56
 */

namespace Atm\Helpers;

use DateTime;

class DateHelper
{
    /**
     * @param $date
     * @return string
     */
    public static function dateToWeekNumber($date)
    {
        $d_date = new DateTime(date('Y-m-d', strtotime($date)));
        $week = $d_date->format("Y-W");

        return $week;
    }
}