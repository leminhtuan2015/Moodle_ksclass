<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/25/16
 * Time: 11:48 AM
 */

require_once("../../../config.php");
global $DB;
$tables = $DB->get_tables();
$tablesCount = array();
foreach ($tables as $table){
    $count = $DB->count_records($table);
    array_push($tablesCount, array($table => $count));
}

echo json_encode($tablesCount);