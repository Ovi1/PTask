<?php
/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-24
 * Time: 20:39
 */

namespace Atm\Taxes\Commissions;

class CashInFee
{
    protected $cash_in_fee = CASH_IN_FEE;
    protected $cash_in_fee_max = CASH_IN_FEE_MAX; // 5€

    public function cashInFee($amount)
    {
        $amount_fee = ($amount * self::getCashInFee()) / 100;
        $final_fee = $amount_fee > self::getCashInFeeMax() ? self::getCashInFeeMax() : $amount_fee;

        return $final_fee;
    }

    /**
     * @return float
     */
    public function getCashInFee(): float
    {
        return $this->cash_in_fee;
    }

    /**
     * @return float
     */
    public function getCashInFeeMax(): float
    {
        return $this->cash_in_fee_max;
    }
}