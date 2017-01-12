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

global $DB, $USER;
$dao = new ks_question();

class rest_question {

    public function create(){
        global $dao;

        $questionStrings = optional_param('questions', "", PARAM_TEXT);
        $questions = (array) json_decode($questionStrings);

        error_log(print_r($questions, true));

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
            $questionObject = $dao->create($question);
            $question->resultText = "Success";
            $question->id = $questionObject->id;
        }
        echo json_encode($questions);
        return;
    }

    public function getByTag(){
        global $dao, $DB;

        $tagStrings = optional_param('tag', "", PARAM_TEXT);
        $data_type = optional_param('data_type', "", PARAM_TEXT);

        $tags = (array) json_decode($tagStrings);
        $questions = $dao->getByTag($tags);

        foreach ($questions as $question){
            $question->timemodified = DateUtil::getHumanDate($question->timemodified);
//            $question_data = $dao->get($question->id);
//            $question->data = $question_data;

//            error_log(print_r($question, true));
        }

        if($data_type == "html"){
            include ("../views/question_list.php");
        } else {
            echo json_encode($questions);
        }

    }

    public function getByIds(){
        global $dao;

        $idStrings = optional_param('id', "", PARAM_TEXT);
        $ids = (array) json_decode($idStrings);
        $questions = $dao->getByIds($ids);

        echo json_encode($questions);
    }

    public function get(){
        global $dao;

        $id = optional_param('id', "", PARAM_INT);
        $question = $dao->get($id);
        echo json_encode($question);
    }

    public function delete(){
        global $dao;

        $id = optional_param('id', "", PARAM_TEXT);
        $dao->delete($id);
        echo true;
    }

}

