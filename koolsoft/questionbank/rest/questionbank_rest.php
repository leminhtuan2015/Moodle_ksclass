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
require_once("../../question/models/ks_question.php");
require_once($CFG->libdir . '/questionlib.php');

global $DB;

$categoryid  = optional_param('categoryid', 0, PARAM_INT);
$idQuestionTxt = optional_param('idDeletes', 0, PARAM_TEXT);

$dao = new ks_question();
if($categoryid && $categoryid > 0){
    $questions = $dao->load_questions($categoryid);
    echo json_encode($questions);
}else if($idQuestionTxt){
    $idQuestions = explode( ',', $idQuestionTxt);
    if(!questions_in_use($idQuestions)){
        foreach ($idQuestions as $idQuestion){
            question_delete_question($idQuestion);
        }
        echo "true";
    }else {
        echo "false";
    }

}



