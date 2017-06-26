<?php

/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-05
 * Time: 11:09
 */

namespace Atm\Core;

class Atm
{
    /**
     * Atm constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $usersArray = [];
        foreach ($data as $transaction) {
            $date          = $transaction['date'];
            $id            = $transaction['client_id'];
            $clientType    = $transaction['client_type'];
            $operationType = $transaction['operation_type'];
            $cash          = $transaction['amount'];
            $currency      = $transaction['currency'];
            $inArray       = false;
            foreach ($usersArray as $user) {
                if ($user->getId() == $id) {
                    $inArray = true;
                    break;
                }
            }
            if ( ! $inArray) {
                $usersArray[$id] = new Client($id, $clientType);
            }
            $operation = [$operationType, $cash, $currency, $date, $clientType];
            fwrite(STDOUT, $usersArray[$id]->operation($operation) . "\r\n");
        }
    }

    public static function formatAmount($amount)
    {
        return number_format($amount, 2, '.', '');
    }
}