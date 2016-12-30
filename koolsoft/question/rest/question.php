<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/27/16
 * Time: 12:00 PM
 */

require_once("../../../config.php");
require_once("../../question/models/ks_question.php");
require_once($CFG->libdir . '/questionlib.php');
require_once(__DIR__.'/../../../question/editlib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/formslib.php');
require_once(__DIR__."/../../../question/type/questiontypebase.php");

global $DB;
$dao = new ks_question();

// action add, update, list, delete
$action = optional_param('action', "", PARAM_TEXT);
global $USER;
switch ($action) {
    case "create":
        $id = optional_param('id', "", PARAM_TEXT);
        if ($id) {
            if (!$question = $DB->get_record('question', array('id' => $id))) {
                print_error('questiondoesnotexist', 'question', "");
            }
            get_question_options($question, true);
        } else {
            $categoryId = optional_param('categoryId', "", PARAM_INT);
            $question = new stdClass();
            $question->category = $categoryId;
            $question->qtype = "multichoice";
            $question->createdby = $USER->id;
        }

        $qtypeobj = question_bank::get_qtype($question->qtype);
        $wrongAnswers = optional_param('wrongAnswer', "", PARAM_TEXT);
        $questionText = optional_param('question', "", PARAM_TEXT);
        $answer = optional_param('answer', "", PARAM_TEXT);
        $categoryId = optional_param('categoryId', "", PARAM_INT);
        if(!$questionText){
            $question->resultText = "Question is empty!";
            echo json_encode($question);
        }else if(!$answer){
            $question->resultText = "Answer is empty!";
            echo json_encode($question);
        }else if(!$wrongAnswers || count($wrongAnswers) <= 0){
            $question->resultText = "Wrong Answer is empty!";
            echo json_encode($question);
        }else{
            $formQuestion = $dao->getData($wrongAnswers, $questionText, $answer, $categoryId);
            $question = $qtypeobj->save_question_no_context($question, $formQuestion);
            $question->resultText = "Success";
            echo json_encode($question);
        }
        break;
    case "update":
        ;
        break;
    case "list":
        $categoryId = optional_param('categoryId', "", PARAM_INT);
        $questions = $dao->load_questions($categoryId);
        echo json_encode($questions);
        break;
    case "one":
        $id = optional_param('id', "", PARAM_INT);
        $question = $dao->load_question($id);
        echo json_encode($question);
        break;
    case "delete":
        $id = optional_param('id', "", PARAM_TEXT);
        $dao->delete_question($id);
        echo true;
        break;
}

