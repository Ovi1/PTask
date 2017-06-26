<?php
/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-24
 * Time: 20:39
 */

namespace Atm\Taxes\Commissions;

use Atm\Core\Client;
use Atm\Money\Currencies;

class CashInFee extends Client
{
    protected $cash_in_fee = CASH_IN_FEE;
    protected $cash_in_fee_max = CASH_IN_FEE_MAX; // 5€

    public function cashInFee($amount, $currency)
    {
        $amount_fee = (Currencies::exchange($amount, $currency) / 100) * self::getCashInFee();
        $final_fee  = $amount_fee > self::getCashInFeeMax() ? self::getCashInFeeMax() : $amount_fee;

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