<?php
/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-24
 * Time: 20:39
 *
 * Pinigų išgryninimas
 * Taikomi skirtingi komisiniai mokesčiai fiziniams ir juridiniams asmenims.
 * Fiziniams asmenims (natural)
 * Įprastas komisinis - 0.3 % nuo sumos.
 *
 * 1000.00 EUR per savaitę (nuo pirmadienio iki sekmadienio) galima išsiimti nemokamai.
 *
 * Ši nuolaida taikoma tik pirmoms 3 išėmimo operacijoms per savaitę - jei išsiimama 4-tą ir paskesnius kartus, komisinis toms operacijoms skaičiuojamas įprastai
 * - taisyklė dėl 1000 EUR galioja tik pirmiesiems trims išgryninimams.
 *
 * Jei suma viršijama - komisinis skaičiuojamas tik nuo viršytos sumos (t.y. vis dar galioja 1000 EUR be komiso).
 *
 * Juridiniams asmenims (legal)
 * Komisinis mokestis - 0.3% nuo sumos, bet ne mažiau nei 0.50 EUR.
 * Komisinio mokesčio valiuta
 * Komisinis mokestis visuomet skaičiuojamas ta valiuta, kuria atliekama operacija (pvz. išsiimant USD, komisinis taip pat būna USD valiuta).
 * Apvalinimas
 * Paskaičiavus komisinį mokestį, jis apvalinamas mažiausio valiutos vieneto (pvz. EUR valiutai - centų) tikslumu į didžiąją pusę (0.023 EUR apvalinasi į 3 Euro centus).
 *
 * Apvalinimas atliekamas jau po konvertavimo.
 */

namespace Atm\Taxes\Commissions;

use Exception;

class CashOutFee
{
    protected $cash_out_fee_legal = CASH_OUT_FEE_FOR_LEGAL;
    protected $cash_out_fee_natural = CASH_OUT_FEE_FOR_NATURAL;
    protected $cash_out_fee_min = CASH_OUT_FEE_MIN_FOR_LEGAL;


    /**
     * @param $amount
     * @param $client_type
     * @return float|int
     * @throws Exception
     */
    public function cashOutFee($amount, $client_type)
    {
        switch ($client_type) {
            case 'legal':
                $amount_fee = ($amount * self::getCashOutFeeLegal()) / 100;
                $final_fee = $amount_fee < self::getCashOutFeeMin() ? self::getCashOutFeeMin() : $amount_fee;
                return $final_fee;
                break;
            case 'natural':
                return ($amount * self::getCashOutFeeNatural()) / 100;
                break;
            default:
                throw new Exception('Invalid client type');
        }
    }

    /**
     * @return float
     */
    public function getCashOutFeeLegal(): float
    {
        return $this->cash_out_fee_legal;
    }

    /**
     * @return float
     */
    public function getCashOutFeeNatural(): float
    {
        return $this->cash_out_fee_natural;
    }

    /**
     * @return float
     */
    public function getCashOutFeeMin(): float
    {
        return $this->cash_out_fee_min;
    }
}