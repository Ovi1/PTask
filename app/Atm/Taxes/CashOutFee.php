<?php
/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-24
 * Time: 20:39
 *  Pinigų išgryninimas
 *
 * Taikomi skirtingi komisiniai mokesčiai fiziniams ir juridiniams asmenims.
 *
 * Fiziniams asmenims
 *
 * Įprastas komisinis - 0.3 % nuo sumos.
 *
 * 1000.00 EUR per savaitę (nuo pirmadienio iki sekmadienio) galima išsiimti nemokamai.
 * Ši nuolaida taikoma tik pirmoms 3 išėmimo operacijoms per savaitę - jei išsiimama 4-tą ir paskesnius kartus, komisinis toms operacijoms skaičiuojamas įprastai - taisyklė dėl 1000 EUR galioja tik pirmiesiems trims išgryninimams.
 * Jei suma viršijama - komisinis skaičiuojamas tik nuo viršytos sumos (t.y. vis dar galioja 1000 EUR be komiso).
 *
 * Juridiniams asmenims
 *
 * Komisinis mokestis - 0.3% nuo sumos, bet ne mažiau nei 0.50 EUR.
 *
 * Komisinio mokesčio valiuta
 *
 * Komisinis mokestis visuomet skaičiuojamas ta valiuta, kuria atliekama operacija (pvz. išsiimant USD, komisinis taip pat būna USD valiuta).
 *
 * Apvalinimas
 *
 * Paskaičiavus komisinį mokestį, jis apvalinamas mažiausio valiutos vieneto (pvz. EUR valiutai - centų) tikslumu į didžiąją pusę (0.023 EUR apvalinasi į 3 Euro centus).
 *
 * Apvalinimas atliekamas jau po konvertavimo.
 */

namespace Atm\Taxes\Commissions;

use Atm\Core\Client;
use Atm\Money\Currencies;

class CashOutFee extends Client
{
    protected $cash_out_fee = CASH_OUT_FEE;
    protected $cash_out_fee_min = CASH_OUT_FEE_MIN;
    protected $cash_out_free_amount = CASH_OUT_FREE_AMOUNT;
    protected $cash_out_discount_times = CASH_OUT_FEE_DISCOUNT_TIMES;

    /**
     * @param $amount
     * @param $currency
     * @param $date
     * @param $client_type
     *
     * @return float|int|null
     * @internal param $client_id
     */
    public function cashOutFee($amount, $currency, $date, $client_type)
    {
        $final_fee = null;
        switch ($client_type) {
            case 'legal':
                $amount_fee = (Currencies::exchange($amount, $currency) / 100) * self::getCashOutFee();
                $final_fee  = $amount_fee < self::getCashOutFeeMin() ? self::getCashOutFeeMin() : $amount_fee;
                break;
            case 'natural':
                return null;
            default:
                die('Invalid client type');
        }

        return $final_fee;
    }


    /**
     * @return float
     */
    public function getCashOutFee(): float
    {
        return $this->cash_out_fee;
    }

    /**
     * @return float
     */
    public function getCashOutFeeMin(): float
    {
        return $this->cash_out_fee_min;
    }

    /**
     * @return int
     */
    public function getCashOutDiscountTimes(): int
    {
        return $this->cash_out_discount_times;
    }

    /**
     * @return int
     */
    public function getCashOutFreeAmount(): int
    {
        return $this->cash_out_free_amount;
    }
}