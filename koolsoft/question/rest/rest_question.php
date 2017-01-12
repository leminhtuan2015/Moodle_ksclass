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

//        error_log(print_r($questions, true));

        // save
        foreach ($questions as $question){
            $questionObject = $dao->create($question);
            $question->resultText = "Success";
            $question->id = $questionObject->id;

            echo "<tr id='question_list_table_row_$question->id'>";
            include ("../views/question_row.php");
            echo "</tr>";
        }
    }

    public function edit(){
        global $dao;

        $id = optional_param('id', "", PARAM_TEXT);
        $question = $dao->get($id);
        $question->data = $question;

        include ("../views/edit.php");
    }

    public function update(){
        global $dao;

        $questionStrings = optional_param('questions', "", PARAM_TEXT);
        $questions = (array) json_decode($questionStrings);

        $question = null;

        foreach ($questions as $q){
            $questionObject = $dao->create($q);
            $q->resultText = "Success";
            $q->id = $questionObject->id;

            $question = $q;
        }
//        error_log(print_r($question, true));

        include ("../views/question_row.php");
    }

    public function getByTag(){
        global $dao, $DB;

        $tagStrings = optional_param('tag', "", PARAM_TEXT);
        $data_type = optional_param('data_type', "", PARAM_TEXT);

        $tags = (array) json_decode($tagStrings);
        $questions = $dao->getByTag($tags);

        foreach ($questions as $question){
            $question->timemodified = DateUtil::getHumanDate($question->timemodified);
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

