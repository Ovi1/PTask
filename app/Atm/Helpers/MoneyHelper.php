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

    /**
     * @param float $value
     * @param int $precision
     * @return string
     */
    public static function roundUp($value, $precision = 0)
    {
        if ($precision < 0) {
            $precision = 0;
        }
        $mult = pow(10, $precision);
        return number_format(ceil($value * $mult) / $mult, $precision);
    }
}