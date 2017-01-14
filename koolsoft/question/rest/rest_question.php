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
require_once($CFG->dirroot . '/koolsoft/dependency/Spout/Autoloader/autoload.php');

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

global $DB, $USER;
$dao = new ks_question();

class rest_question {
    public static $EMPTY_QUESTION = "ks_mark_emptyquestion_1108";

    public function create(){
        global $dao;

        $questionStrings = optional_param('questions', "", PARAM_TEXT);
        $questions = (array) json_decode($questionStrings);

//        error_log(print_r($questions, true));

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
        $page = optional_param('page', "", PARAM_TEXT);

        $tags = (array) json_decode($tagStrings);
        $questions = $dao->getByTag($tags, $page);

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
//        error_log(print_r($status, true));
        echo true;
    }

    public function show(){
        global $dao;

        $id = optional_param('id', "", PARAM_TEXT);
        $question = $dao->get($id);
//      error_log(print_r($question, true));

        include ("../views/show.php");
    }

    public function import(){
        global $dao;

        error_log(print_r($_FILES['file'], true));

        if(!strpos($_FILES['file']["name"], "xls")){
            echo false;
            return;
        }

        $reader = ReaderFactory::create(Type::XLSX);
        $fileSaveTo = $_FILES['file']['tmp_name'].round(microtime(true) * 1000);
        $status = move_uploaded_file( $_FILES['file']['tmp_name'], $fileSaveTo);
        $reader->open($fileSaveTo);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                // $row is a array , each cell is a element in array
                $question = $this->buildQuestionObjectFromRowExcel($row);
//                error_log(print_r($question, true));
                $dao->create($question);
            }
        }

        unlink ($fileSaveTo);
        $reader->close();
        echo true;
    }

    private function buildQuestionObjectFromRowExcel($row){
        //       {"questions":"[{\"id\":\"undefined\",\"question\":\"4\",\"answer\":\"4\",\"qtype\":\"multichoice\",\"tags\":[],\"wrongAnswer\":[\"4\",\"4\",\"4\"]}]"}

        $question = new stdClass();

        $questionText = $row[0];
        $answer = $row[2];
        $wrongAnswer1 = "$row[3]";
        $wrongAnswer2 = "$row[4]";
        $wrongAnswer3 = "$row[5]";

        $question->id = "";
        $question->question = $questionText;
        $question->answer = $answer;
        $question->qtype = "multichoice";
        $question->wrongAnswer = [$wrongAnswer1, $wrongAnswer2, $wrongAnswer3];

        return $question;
    }

}

