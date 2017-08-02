<?php
/**
 * Created by PhpStorm.
 * User: ovidi
 * Date: 2017-07-29
 * Time: 10:57
 */

namespace Atm\Helpers;

class MoneyHelper
{
    public static function roundUp($amount, $precision = 0)
    {
        if ($precision < 0) {
            $precision = 0;
        }
        $pow = pow(10, $precision);

        return number_format(ceil($amount * $pow) / $pow, $precision);
    }
}