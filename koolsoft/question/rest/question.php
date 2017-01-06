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
require_once($CFG->dirroot . '/koolsoft/utility/DateUtil.php');
require_once(__DIR__."/../../../question/type/questiontypebase.php");

global $DB;
$dao = new ks_question();

// action add, update, list, delete
$action = optional_param('action', "", PARAM_TEXT);
global $USER;
switch ($action) {
    case "create":
        $questionStrings = optional_param('questions', "", PARAM_TEXT);
        $questions = (array) json_decode($questionStrings);

        // validation
        foreach ($questions as $question){
            if(!$question->question){
                $question->resultText = "Question is empty!";
                echo json_encode($questions);
                return;
            }else if(!$question->answer){
                $question->resultText = "Answer is empty!";
                echo json_encode($questions);
                return;
            }else if(!$question->wrongAnswer || count($question->wrongAnswer) <= 0){
                $question->resultText = "Wrong Answer is empty!";
                echo json_encode($questions);
                return;
            }else {
                foreach ($question->wrongAnswer as $wrongAnswer){
                    if(!$wrongAnswer){
                        $question->resultText = "Wrong Answer is empty!";
                        echo json_encode($questions);
                        return;
                    }
                }
            }
        }

        // save
        foreach ($questions as $question){
            $dao->create($question);
            $question->resultText = "Success";
        }
        echo json_encode($questions);
        return;
        break;
    case "update":
        ;
        break;
    case "listByTag":
        $tagStrings = optional_param('tag', "", PARAM_TEXT);
        $tags = (array) json_decode($tagStrings);
        $questions = $dao->loadByTag($tags);
        foreach ($questions as $question){
            $question->timemodified = DateUtil::getHumanDate($question->timemodified);
        }
        echo json_encode($questions);
        break;
    case "listByIds":
        $idStrings = optional_param('id', "", PARAM_TEXT);
        $ids = (array) json_decode($idStrings);
        $questions = $dao->loadByIds($ids);

        echo json_encode($questions);
        break;
    case "one":
        $id = optional_param('id', "", PARAM_INT);
        $question = $dao->loadOne($id);
        echo json_encode($question);
        break;
    case "delete":
        $id = optional_param('id', "", PARAM_TEXT);
        $dao->delete($id);
        echo true;
        break;
}

