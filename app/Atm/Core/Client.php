<?php
/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-26
 * Time: 20:35
 */

namespace Atm\Core;

use Atm\Taxes\Commissions\CashInFee;
use Atm\Taxes\Commissions\CashOutFee;

class Client
{
    private $id;
    private $userType;
    private $cashOutWeek;
    private $cashOutCount;
    private $limit;
    private $week;
    private $lastDate;

    public function __construct($id, $userType)
    {
        $this->setLastDate("1000-01-01");
        $this->setWeek(0);
        $this->setId($id);
        $this->setUserType($userType);
        $this->setCashOutWeek(0);
        $this->setCashOutCount(0);
        $this->setLimit(CASH_OUT_FREE_AMOUNT);
    }

    /**
     * @param array $operation
     */
    public function operation(array $operation)
    {
        switch ($operation[0]) {
            case "cash_in":
                $inFee       = new CashInFee($this->getId(), $this->getUserType());
                $cash_in_fee = $inFee->cashInFee($operation[1], $operation[2]);
                echo self::formatAmount($cash_in_fee);
                break;
            case "cash_out":
                $outFee       = new CashOutFee($this->getId(), $this->getUserType());
                $cash_out_fee = $outFee->cashOutFee($operation[1], $operation[2], $operation[3], $operation[4]);
                echo self::formatAmount($cash_out_fee);
                break;
            default:
                die('Wrong operation type');
        }
    }

    public static function formatAmount($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    public function isOverCashLimit()
    {
        if ($this->cashOutWeek > CASH_OUT_FREE_AMOUNT) {
            return true;
        } else {
            return false;
        }
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

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @param mixed $userType
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
    }

    /**
     * @return mixed
     */
    public function getCashOutWeek()
    {
        return $this->cashOutWeek;
    }

    /**
     * @param mixed $cashOutWeek
     */
    public function setCashOutWeek($cashOutWeek)
    {
        $this->cashOutWeek = $cashOutWeek;
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
        $this->cashOutCount = $cashOutCount;
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
}