<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/23/16
 * Time: 3:28 PM
 */
if (!defined('AJAX_SCRIPT')) {
    define('AJAX_SCRIPT', true);
}
require_once("../../../config.php");
require_once("../../shared/dao/dao.php");

$quizid  = optional_param('quizId', 0, PARAM_INT);
$action  = optional_param('action', 0, PARAM_INT);
$idslot  = optional_param('idSlot', 0, PARAM_INT);
$dao = new dao();
if($quizid){
    $slots = $dao->load_slots_in_quiz($quizid);
    echo json_encode($slots);
}else if($action == "removeSlot"){
    $dao->remove_slot($idslot);
    echo "true";
}
