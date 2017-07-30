<?php

/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-07
 * Time: 17:46
 */

namespace Atm\Data;

use Atm\Helpers\DateHelper;

class File
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @return array
     */
    public function formatFileData()
    {
        $raw_data = array_map('str_getcsv', file($this->getFile()));
        $formatted_data = array();
        foreach ($raw_data as $data) {
            $formatted_data[] = array('date' => $data[0], 'week_number' => DateHelper::dateToWeekNumber($data[0]), 'client_id' => $data[1], 'client_type' => $data[2], 'operation_type' => $data[3], 'amount' => $data[4], 'currency' => $data[5],);
        }
        return $formatted_data;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

}