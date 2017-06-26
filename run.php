<?php
/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-05
 * Time: 12:57
 */
if (isset($argv[1])) {
    $file = $argv[1];
} else {
    die('Nepateiktas failas');
}
require_once('app/start.php');
$data = new \Atm\Data\File($file);
$var  = new Atm\Core\Atm($data->formatFileData());