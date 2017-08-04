<?php

/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-05
 * Time: 11:09
 */

namespace Atm\Core;

//Config file for default values
new Config();

class Atm
{
    public function __construct($data)
    {

        $clientsArray = [];
        foreach ($data as $transaction) {

            $inArray = false;
            foreach ($clientsArray as $user) {
                if ($user->getId() == $transaction['client_id']) {
                    $inArray = true;
                    break;
                }
            }
            if (!$inArray) {
                $clientsArray[$transaction['client_id']] = new Client($transaction['client_id'],
                    $transaction['client_type'], $transaction['week_number'], $transaction['date']);
            }
            fwrite(STDOUT, $clientsArray[$transaction['client_id']]->operation($transaction) . "\r\n");
        }
    }
}