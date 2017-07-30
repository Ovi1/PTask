<?php
/**
 * Created by PhpStorm.
 * User: Ovidijus
 * Date: 2017-06-05
 * Time: 12:57
 */

if (isset($argv[1])) {
    require_once('app/start.php');
    $file = $argv[1];
    $data = new \Atm\Data\File($file);
    new Atm\Core\Atm($data->formatFileData());
} else {
    die('Nepateiktas .CSV failas');
}