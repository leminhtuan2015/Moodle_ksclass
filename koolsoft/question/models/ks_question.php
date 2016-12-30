<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/24/16
 * Time: 2:12 AM
 */

global $CFG;
require_once($CFG->dirroot."/config.php");
require_once($CFG->libdir . '/questionlib.php');
require_once(__DIR__.'/../../../question/editlib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/formslib.php');
require_once(__DIR__."/../../../question/type/questiontypebase.php");
class ks_question
{
    function __construct() {

    }

    public function load_questions($categoryId){
        global $DB;
        $sql = 'SELECT * FROM ks_question WHERE category ='.$categoryId;
        $param = array();
        $questions = $DB->get_records_sql($sql, $param);
        foreach ($questions as $question){
            get_question_options($question, true);
        }
        return $questions;
    }

    public function load_question($id){
        global $DB;
        $param = array("id" => $id);
        $question = $DB->get_record("question", $param);
        get_question_options($question, true);
        return $question;
    }

    public function delete_question($id){
//        question_require_capability_on($id, 'edit');
        if (questions_in_use(array($id))) {
            global $DB;
            $DB->set_field('question', 'hidden', 1, array('id' => $id));
        } else {
            question_delete_question($id);
        }
    }

    public function getData($wrongAnswers, $questionText, $answer, $categoryId){
        $question = new stdClass();
        $question->category = $categoryId;

        $question->name = $questionText;
        $question->id = optional_param('id', "", PARAM_INT);
        $question->length = "1";
        $question->penalty = "0";
        $question->questiontext = array(text => $questionText, format => "1", defaultmark =>"1");
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
        $correctAnswer = array(text => $answer, format => "1");
        $answers = array($correctAnswer);
        $feedback = array(text => "f", format => "1");
        $feedbacks = array($feedback);
        $fractions = array("1.0");
        foreach ($wrongAnswers as $wrongAnswer){
            $wrongAnswerObjects = array(text => $wrongAnswer, format => "1");
            array_push($answers, $wrongAnswerObjects);
            $feedbackWrong = array(text => "f", format => "1");
            array_push($feedbacks, $feedbackWrong);
            array_push($fractions, "0.0");
        }

        $question->fraction = $fractions;

        $question->answer = $answers;
        $question->feedback = $feedbacks;

        $question->correctfeedback = array(text => "correct", format => "1");
        $question->partiallycorrectfeedback = array(text => "partially correct", format => "1");
        $question->shownumcorrect = 1;
        $question->incorrectfeedback = array(text => "incorrectfeedback", format => "1");

        return $question;
    }

}