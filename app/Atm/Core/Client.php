<?php
/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-26
 * Time: 20:35
 */

namespace Atm\Core;

use Atm\Helpers\DateHelper;
use Atm\Helpers\MoneyHelper;
use Atm\Money\Currencies;
use Atm\Taxes\Commissions\CashInFee;
use Atm\Taxes\Commissions\CashOutFee;
use Exception;

class Client
{
    private $id;
    private $clientType;
    private $cashOutThisWeek;
    private $cashOutCount;
    private $limit;
    private $week;
    private $lastDate;

    public function __construct($id, $clientType)
    {
        $this->setId($id);
        $this->setClientType($clientType);
        $this->setWeek(0);
        $this->setLastDate("1000-01-01");
        $this->cashOutThisWeek = 0;
        $this->setCashOutCount(0);
        $this->setLimit(CASH_OUT_FREE_MAX_AMOUNT);
    }

    public function operation(array $operation)
    {
        switch ($operation[0]) {
            case "cash_in":
                $c = new Currencies;
                $inFee = new CashInFee();
                $amount = $c->exchange($operation[1], $operation[2]);
                $precision = $c->precision($operation[2]);
                $cash_in_fee = $inFee->cashInFee($amount);
                echo MoneyHelper::roundUp($cash_in_fee, $precision);
                break;
            case "cash_out":
                $c = new Currencies;
                $outFee = new CashOutFee();
                $amount = $c->exchange($operation[1], $operation[2]);
                $precision = $c->precision($operation[2]);
                $rates = $c->rates($operation[2]);


                if (!$this->isNatural()) {
                    $cash_out_fee = $outFee->cashOutFee($amount, $this->getClientType());

                    return MoneyHelper::roundUp($cash_out_fee * $rates, $precision);

                } else {

                    while ($this->getWeek() == 0) {
                        $this->setWeek(DateHelper::dateToWeekNumber($operation[3]));
                        $this->setLastDate($operation[3]);
                    }
                    if ($this->getLastDateWeek() != DateHelper::dateToWeekNumber($operation[3])) {
                        $this->cashOutCount = 0;
                        //for next week increase by one;
                        $this->cashOutCount++;
                        $this->cashOutThisWeek = 0;
                        $this->setWeek(DateHelper::dateToWeekNumber($operation[3]));
                    } else {
                        $this->cashOutThisWeek++;
                        $this->setCashOutCount($amount);
                        $this->setWeek(DateHelper::dateToWeekNumber($operation[3]));
                    }

                    if ($this->cashOutThisWeek <= CASH_OUT_FEE_DISCOUNT_TIMES_NATURAL) {
                        if ($this->getCashOutCount() <= $this->getLimit()) {
                            return MoneyHelper::roundUp(0, $precision);
                        } else if ($amount >= $this->getLimit()) {
                            $amount_above_limit = $this->getCashOutCount() - $this->getLimit();
                            $cash_out_fee = $outFee->cashOutFee($amount_above_limit, $this->getClientType());

                            return MoneyHelper::roundUp($cash_out_fee * $rates, $precision);
                        } else {
                            $cash_out_fee = $outFee->cashOutFee($amount, $this->getClientType());

                            return MoneyHelper::roundUp($cash_out_fee * $rates, $precision);
                        }
                        //legal
                    } else {
                        $cash_out_fee = $outFee->cashOutFee($amount, $this->getClientType());

                        return MoneyHelper::roundUp($cash_out_fee * $rates, $precision);
                    }
                }
                break;
            default:
                throw new Exception('Wrong operation type ' . $operation[0]);
        }
    }

    /**
     * @return mixed
     */
    public function getClientType()
    {
        return $this->clientType;
    }

    /**
     * @param mixed $clientType
     */
    public function setClientType($clientType)
    {
        $this->clientType = $clientType;
    }


    /**
     * @return bool
     */
    public function isNatural()
    {
        return $this->getClientType() === 'natural' ? true : false;
    }

    /**
     * @return mixed
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * @param mixed $week
     */
    public function setWeek($week)
    {
        $this->week = $week;
    }

    public function getLastDateWeek()
    {
        return DateHelper::dateToWeekNumber($this->getLastDate());
    }

    /**
     * @return mixed
     */
    public function getLastDate()
    {
        return $this->lastDate;
    }

    /**
     * @param mixed $lastDate
     */
    public function setLastDate($lastDate)
    {
        $this->lastDate = $lastDate;
    }

    /**
     * @return mixed
     */
    public function getCashOutCount()
    {
        return $this->cashOutCount;
    }

    /**
     * @param mixed $cashOutCount
     */
    public function setCashOutCount($cashOutCount)
    {
        $this->cashOutCount += $cashOutCount;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}