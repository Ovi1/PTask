<?php
/**
 * Created by PhpStorm.
 * User: ovidi
 * Date: 2017-07-29
 * Time: 10:53
 */

namespace Atm\Data;

use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function test_data_file_headers(): void
    {
        $data_keys_expected = array(
            'date',
            'week_number',
            'client_id',
            'client_type',
            'operation_type',
            'amount',
            'currency'
        );
        $file = new File('input.csv');
        $formatted_data = $file->formatFileData();
        $array_keys = array_keys($formatted_data[0]);
        $this->assertEquals($data_keys_expected, $array_keys);
    }
}
