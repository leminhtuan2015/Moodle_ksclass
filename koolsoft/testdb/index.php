<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/25/16
 * Time: 11:48 AM
 */
//
//require_once("../../config.php");
//
////global $DB;
////$tables = $DB->get_tables();
////foreach ($tables as $table){
////    $count = $DB->count_records($table);
////    echo $table.$count."<br>";
////}
//

$input = array("red", "green", "blue", "yellow");
$input2 = array("red1");
$input3 = array("red2");
$input3 = array_merge($input, $input2, $input3);
print_r($input3);
?>
<!--<script src="/moodle/koolsoft/resources/javascript/jquery.3.1.0.min.js"></script>-->
<!--<script src="/moodle/koolsoft/testdb/resources/javascript/testdb.js"></script>-->
<!--<button id="btnCompare">Compare</button>-->
<!--TABLE CHANGE: ---------------------------------------------------->
<!--<div id = "result">-->
<!---->
<!--</div>-->
<!--<br>-->
