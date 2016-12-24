<?php
/**
 * Created by PhpStorm.
 * User: dungdv
 * Date: 12/15/16
 * Time: 9:41 PM
 */
//
require_once("../../config.php");
require_once(__DIR__.'/../../question/editlib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/formslib.php');
require_once(__DIR__."/../application/ApplicationController.php");
require_once(__DIR__."/../../question/type/questiontypebase.php");

class QuestionController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        require_once(__DIR__.'/views/index.php');
    }
    public function show($id) {

        require_once(__DIR__.'/views/show.php');
    }

    public function edit($idCategory) {
        global $PAGE, $COURSE, $DB;
        $save = $_POST["save"];
        $returnUrl = optional_param("returnUrl", "", PARAM_TEXT);
        if($returnUrl == ""){
            $returnUrl = $_POST["returnUrl"];
        }

        if($save == "true"){
            $this->save_question();
//            if($returnUrl){
            echo "<script type='text/javascript'> window.location.replace('".urldecode($returnUrl)."')</script>";
//            }
        }else {
            $category = $DB->get_record("question_categories", array("id"=>$idCategory));
            $questionInDatabase = $this->load_questions($idCategory);
            get_question_options($questionInDatabase, true);

            $listQuestion = array();
            foreach ($questionInDatabase as $question){
                array_push($listQuestion, $question);
            }

            $questionHtml = "";
            $numberQuestion = count($listQuestion);
            for($i = 0 ; $i < count($listQuestion); $i++){
                $questionHtml = $questionHtml.$this->generateQuestion($listQuestion[$i], $i);
            }
            require_once(__DIR__.'/views/edit.php');
        }
    }

    public function save_question() {
        global $DB, $USER;
        $categoryId = $_POST["category"];
        $numberQuestion = $_POST["numberQuestion"];
        for($stt = 0; $stt < $numberQuestion; $stt++) {
            $id = $_POST["id".$stt];
            $question = null;
            if ($id) {
                if (!$question = $DB->get_record('question', array('id' => $id))) {
                    print_error('questiondoesnotexist', 'question', "");
                }
                get_question_options($question, true);

            } else {
                $question = new stdClass();
                $question->category = $categoryId;
                $question->qtype = "multichoice";
                $question->createdby = $USER->id;
            }
            $qtypeobj = question_bank::get_qtype($question->qtype);
            error_log(json_encode($this->getData($stt)));
            $qtypeobj->save_question($question, $this->getData($stt));
        }
    }

    public function getData($stt){
        $question = new stdClass();
        $question->category = $_POST["category"];
//        $question->name = $_POST["name" + $stt];
        $question->name = $_POST["questionText".$stt];
        $question->id = $_POST["id".$stt];
        $question->length = "1";
        $question->penalty = "0";
        $question->questiontext = array(text => $_POST["questionText".$stt], format => "1", defaultmark =>"1");
        $question->qtype = "multichoice";
        $question->generalfeedback = "";
        $question->answernumbering = "abc";
        $question->shuffleanswers = "1";
        $question->mform_isexpanded_id_answerhdr = "1";
        $question->noanswers = "5";
        $question->defaultmark = "1";
        $question->single = "1";
        $question->makecopy = "0";
        $question->scrollpos = "0";
        $question->appendqnumstring = "";
        $question->returnurl = "";
        $question->tags = "";

        $question->fraction = array("1.0", "0.0", "0.0", "0.0", "0.0");
        $correctAnswer = array(text => $_POST["answerText".$stt], format => "1");
        $answers = array($correctAnswer);
        $feedback = array(text => "f", format => "1");
        $feedbacks = array($feedback);
        for($i = 0 ; $i < 4; $i ++){
            $wrongAnswer = array(text => $_POST["wrongAnswer".$stt."_".$i], format => "1");
            array_push($answers, $wrongAnswer);
            $feedbackWrong = array(text => "f", format => "1");
            array_push($feedbacks, $feedbackWrong);
        }

        $question->answer = $answers;

        $question->feedback = $feedbacks;

        $question->correctfeedback = array(text => "correct 1", format => "1");
        $question->partiallycorrectfeedback = array(text => "partially correct 1", format => "1");
        $question->shownumcorrect = 1;
        $question->incorrectfeedback = array(text => "incorrectfeedback 1", format => "1");

        return $question;
    }

    public function generateQuestion($question, $stt){
        $answers = $question->options->answers;
        $wrongAnswer = array();
        $i = 0;
        foreach ($answers as $key => $value){
            if($i == 0){
                $correctAnswer = $value;
            }else {
                array_push($wrongAnswer, $value);
            }
            $i++;
        }
        $htmlQuestion = "";
        $htmlQuestion = $htmlQuestion."<div id='question".$stt."' class='form-group'>"
        ."<div class='questionDiv'>"
        ."<label class='control-label questionLable' for='questionText".$stt."'>Question :</label>"
        ."<input class='form-control questionText'  name='questionText".$stt."' placeholder='Question' required value='".$question->questiontext."'></input>"
        ."<input style='display: none' name='id".$stt."' value='".$question->id."'></input>"
        ."</div>"
        ."<div class='answerDiv'>"
        ."<label class='control-label answerLable' for='answerText".$stt."'>Answer :</label>"
        ."<input class='form-control answerText' name='answerText".$stt."' placeholder='Answer' value='".$correctAnswer->answer."' required></input>"
        ."</div>"
        ."<div class='closeDiv'>"
        ."<input class='form-control answerText' name='answerText".$stt."' placeholder='Answer' value='".$correctAnswer->answer."' required></input>"
        ."</div>"
        ."<div id='divWrongAnswer".$stt."'>";
        if(count($wrongAnswer) > 0){
            for($j = 0 ; $j <  count($wrongAnswer); $j ++){
                $htmlQuestion = $htmlQuestion."<input class='form-control' name='wrongAnswer".$stt."_".$j."' placeholder='Wrong Answer' value='".$wrongAnswer[$j]->answer."'required></input>";
            }
        }
        $htmlQuestion = $htmlQuestion."</div>"
//        ."<button id='addWrongAnswer".$stt."'>Add wrong answer</button>"
        ."</div>";

        return $htmlQuestion;
    }

    public function load_questions($category){
        global $DB;
        $sql = 'SELECT * FROM question WHERE category ='.$category;
        $param = array();
        $questions = $DB->get_records_sql($sql, $param);
        return $questions;
    }

}