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
require_once("../../shared/dao/dao.php");
require_once($CFG->libdir . '/questionlib.php');
//require_once(__DIR__.'/../../question/editlib.php');
//require_once($CFG->libdir . '/filelib.php');
//require_once($CFG->libdir . '/formslib.php');

global $DB;

$categoryid  = optional_param('categoryid', 0, PARAM_INT);
$idQuestionTxt = optional_param('idDeletes', 0, PARAM_TEXT);

$dao = new dao();
if($categoryid && $categoryid > 0){
    $questions = $dao->load_questions($categoryid);
    echo json_encode($questions);
}else if($idQuestionTxt){
    $idQuestions = explode( ',', $idQuestionTxt);
    foreach ($idQuestions as $idQuestion){
        question_delete_question($idQuestion);
    }
    echo "true";
}



