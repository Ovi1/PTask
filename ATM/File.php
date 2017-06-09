<?php

/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-07
 * Time: 17:46
 */
class File extends Atm {
	/**
	 * @ Todo Custom file path and error
	 * @return array
	 */
	public static function formatFileData() {
		$options        = getopt( 'f:' );
		$file           = $options['f'];
		$raw            = array_map( 'str_getcsv', file( $file ) );
		$formatted_data = array();
		foreach ( $raw as $data ) {
			$formatted_data[] = array(
				'date'           => $data[0],
				'client_id'      => $data[1],
				'client_type'    => $data[2],
				'operation_type' => $data[3],
				'amount'         => $data[4],
				'currency'       => $data[5],
			);
		}
		return $formatted_data;
	}
}