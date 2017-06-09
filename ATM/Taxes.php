<?php

/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-05
 * Time: 11:22
 */
class Taxes extends Atm {
	private static $cash_in_fee = 0.03;
	private static $cash_in_fee_max = 5.00; // 5€

	private static $cash_out_fee = 0.3;
	private static $cash_out_fee_max = 1000; // 1000€; @TODO
	private static $cash_out_fee_min = 0.50; // 50ct
	private static $cash_out_discount_times = 3; //First 3 times in week @TODO

	/**
	 * @param $amount
	 * @param $currency
	 *
	 * @return float|string
	 */
	public static function cashInFee( $amount, $currency ) {
		$amount_fee = (Currencies::exchange( $amount, $currency )/100) * self::getCashInFee();
		$final_fee  = $amount_fee > self::getCashInFeeMax() ? self::getCashInFeeMax() : $amount_fee;

		return $final_fee;
	}

	/**
	 * Pinigų išgryninimas
	 *
	 * @TODO
	 * Fiziniams asmenims
	 * Įprastas komisinis - 0.3 % nuo sumos.
	 * 1000.00 EUR per savaitę (nuo pirmadienio iki sekmadienio) galima išsiimti nemokamai.
	 * Jei suma viršijama - komisinis skaičiuojamas tik nuo viršytos sumos (t.y. vis dar galioja 1000 EUR be komiso).
	 * Ši nuolaida taikoma tik pirmoms 3 išėmimo operacijoms per savaitę - jei išsiimama 4-tą ir paskesnius kartus, komisinis toms operacijoms skaičiuojamas įprastai - taisyklė dėl 1000 EUR galioja tik pirmiesiems trims išgryninimams.
	 * @DONE
	 * Juridiniams asmenims
	 * Komisinis mokestis - 0.3% nuo sumos, bet ne mažiau nei 0.50 EUR.
	 *
	 * @param $amount
	 * @param $currency
	 * @param $client_type
	 *
	 * @return float
	 */
	public static function cashOutFee( $amount, $currency, $client_type ) {
		$final_fee = '';
		if ( $client_type === 'legal' ) {
			$amount_fee = ( Currencies::exchange( $amount, $currency ) / 100 ) * self::getCashOutFee();
			$final_fee  = $amount_fee < self::getCashOutFeeMin() ? self::getCashOutFeeMin() : $amount_fee;
		} elseif ( $client_type === 'natural' ) {
			$amount_fee = ( Currencies::exchange( $amount, $currency ) / 100 ) * self::getCashOutFee();
			$final_fee  = $amount_fee < self::getCashOutFeeMin() ? self::getCashOutFeeMin() : $amount_fee;
		}
		return $final_fee;
	}

	/**
	 * @return float
	 */
	public static function getCashOutFeeMin(): float {
		return self::$cash_out_fee_min;
	}

	/**
	 * @param float $cash_out_fee_min
	 */
	public static function setCashOutFeeMin( float $cash_out_fee_min ) {
		self::$cash_out_fee_min = $cash_out_fee_min;
	}

	/**
	 * @return float
	 */
	public static function getCashOutFee(): float {
		return self::$cash_out_fee;
	}

	/**
	 * @param float $cash_out_fee
	 */
	public static function setCashOutFee( float $cash_out_fee ) {
		self::$cash_out_fee = $cash_out_fee;
	}

	/**
	 * @return float
	 */
	public static function getCashInFee(): float {
		return self::$cash_in_fee;
	}

	/**
	 * @param float $cash_in_fee
	 */
	public static function setCashInFee( float $cash_in_fee ) {
		self::$cash_in_fee = $cash_in_fee;
	}

	/**
	 * @return float
	 */
	public static function getCashInFeeMax(): float {
		return self::$cash_in_fee_max;
	}

	/**
	 * @param float $cash_in_fee_max
	 */
	public static function setCashInFeeMax( float $cash_in_fee_max ) {
		self::$cash_in_fee_max = $cash_in_fee_max;
	}
}