<?php

/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-05
 * Time: 11:09
 * Konvertuojant valiutas, taikomi tokie konvertavimo kursai: EUR:USD - 1:1.1497, EUR:JPY - 1:129.53
 */

namespace Atm\Core;

use Atm\Data\File;
use Atm\Taxes\Taxes;

class Atm
{
    private $operation_date;
    private $operation_client_id;
    private $operation_client_type;
    private $operation_type;
    private $operation_amount;
    private $operation_currency;

    /**
     * Atm constructor.
     */
    public function __construct()
    {
        $csv_data = File::formatFileData();
        foreach ($csv_data as $data) {
            $this->stdOut(
                $data['date'],
                $data['client_id'],
                $data['client_type'],
                $data['operation_type'],
                $data['amount'],
                $data['currency']
            );
        }
    }

    /**
     * @param $operation_date
     * @param $operation_client_id
     * @param $operation_client_type
     * @param $operation_type
     * @param $operation_amount
     * @param $operation_currency
     */
    public function stdOut(
        $operation_date,
        $operation_client_id,
        $operation_client_type,
        $operation_type,
        $operation_amount,
        $operation_currency
    ) {
        $this->setOperationClientType($operation_client_type);
        $this->setOperationType($operation_type);
        $this->setOperationAmount($operation_amount);
        $this->setOperationCurrency($operation_currency);

        if ($this->getOperationType() === 'cash_in') {
            $cash_in_fee = Taxes::cashInFee($this->getOperationAmount(), $this->getOperationCurrency());
            echo self::formatAmount($cash_in_fee) . "\r\n";
        } elseif ($this->getOperationType() === 'cash_out') {
            $cash_out_fee = Taxes::cashOutFee($this->getOperationAmount(), $this->getOperationCurrency(),
                $this->getOperationClientType());
            echo self::formatAmount($cash_out_fee) . "\r\n";
        }
    }

    public static function formatAmount($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    /**
     * @param mixed $operation_date
     */
    public function setOperationDate($operation_date)
    {
        $this->operation_date = $operation_date;
    }

    /**
     * @param mixed $operation_client_id
     */
    public function setOperationClientId($operation_client_id)
    {
        $this->operation_client_id = $operation_client_id;
    }

    /**
     * @param mixed $operation_client_type
     */
    public function setOperationClientType($operation_client_type)
    {
        $this->operation_client_type = $operation_client_type;
    }

    /**
     * @param mixed $operation_type
     */
    public function setOperationType($operation_type)
    {
        $this->operation_type = $operation_type;
    }

    /**
     * @param mixed $operation_amount
     */
    public function setOperationAmount($operation_amount)
    {
        $this->operation_amount = $operation_amount;
    }

    /**
     * @param mixed $operation_currency
     */
    public function setOperationCurrency($operation_currency)
    {
        $this->operation_currency = $operation_currency;
    }

    /**
     * @return mixed
     */
    public function getOperationType()
    {
        return $this->operation_type;
    }

    /**
     * @return mixed
     */
    public function getOperationClientType()
    {
        return $this->operation_client_type;
    }

    /**
     * @return mixed
     */
    public function getOperationAmount()
    {
        return $this->operation_amount;
    }

    /**
     * @return mixed
     */
    public function getOperationCurrency()
    {
        return $this->operation_currency;
    }
}