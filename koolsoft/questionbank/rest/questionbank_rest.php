<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/22/16
 * Time: 9:05 PM
 */
if (!defined('AJAX_SCRIPT')) {
    define('AJAX_SCRIPT', true);
}
require_once("../../../config.php");
//require_once(__DIR__.'/../../question/editlib.php');
//require_once($CFG->libdir . '/filelib.php');
//require_once($CFG->libdir . '/formslib.php');

$categoryid     = required_param('categoryid', PARAM_INT);

global $DB;
$sql = 'SELECT * FROM question WHERE category ='.$categoryid;
$param = array();
$questions = $DB->get_records_sql($sql, $param);

echo json_encode($questions);