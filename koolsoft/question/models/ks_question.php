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

class ks_question {
    private static $DEFAULT_CATEGORY_ID = 0;

    public function getByTag($tags){
        global $DB, $USER;

        if($tags && count($tags) > 0){
            $sqlString = "SELECT DISTINCT q.id, q.name, q.timemodified FROM ".$DB->get_prefix()."question q RIGHT JOIN ".$DB->get_prefix()."tag_question t ON q.id = t.id_question AND q.createdby=".$USER->id;
            $sqlString = $sqlString." AND t.id_tag IN (";
            $length = count($tags);
            for($i = 0; $i < $length; $i ++){
                if($i == $length || $i == 0){
                    $sqlString = $sqlString.$tags[$i];
                }else {
                    $sqlString = $sqlString.",".$tags[$i];
                }
            }
            $sqlString = $sqlString.")";
            $sqlString = $sqlString." order by q.timemodified DESC";
            $questions = $DB->get_records_sql($sqlString, array());
        }else {
            $sqlString = "SELECT DISTINCT q.id, q.name, q.timemodified FROM ".$DB->get_prefix()."question q WHERE q.createdby=".$USER->id." order by q.timemodified DESC";
            $questions = $DB->get_records_sql($sqlString, array());
        }
        return $questions;
    }

    public function create($question){
        global $DB, $USER;

        $questionObject = new stdClass();
        if($question->id && $question->id != "undefined" && $question->id != "null"){
            $questionObject->id = $question->id;
        }
        $questionObject->qtype = $question->qtype;
        $questionObject->createdby = $USER->id;
        $questionObject->qtype = "multichoice";
        $qtypeobj = question_bank::get_qtype($questionObject->qtype);
        $data = $this->buildQuestionObject($question->wrongAnswer,
            $question->question, $question->answer,
            ks_question::$DEFAULT_CATEGORY_ID, $questionObject->qtype);
        $questionObject = $qtypeobj->save_question_no_context($questionObject, $data);

        $tags = $question->tags;
        // delete old tag
        $tagQuestions = $this->loadTagQuestion($questionObject->id);
        foreach($tagQuestions as $tagQuestion){
            $this->deleteTagQuestion($tagQuestion->id);
        }
        // add new tag
        foreach($tags as $tag){
            $tagQuestion = new stdClass();
            $tagQuestion->id_tag = $tag;
            $tagQuestion->id_question = $questionObject->id;
            $this->createTagQuestion($tagQuestion);
        }

        return $questionObject;
    }

    public function createTagQuestion($tagQuestion){
        global $DB;
        $tagQuestion->id = $DB->insert_record("tag_question", $tagQuestion);
        return $tagQuestion;
    }

    public function loadTagQuestion($questionId){
        global $DB;
        $sql = 'SELECT * FROM '.$DB->get_prefix().'tag_question WHERE id_question ='.$questionId;
        $tagQuestions = $DB->get_records_sql($sql, array());
        return $tagQuestions;
    }

    public function deleteTagQuestion($id){
        global $DB;
        $DB->delete_records("tag_question", array("id"=>$id));
    }

    public function get($id){
        global $DB;
        $param = array("id" => $id);
        $question = $DB->get_record("question", $param);
        get_question_options($question, true);

        // get tag for question
        $tagQuestions = $this->loadTagQuestion($id);
        $tags = array();

        foreach($tagQuestions as $tagQuestion){
            array_push($tags, $tagQuestion->id_tag);
        }

        $question->tags = $tags;
        return $question;
    }

    public function getByIds($ids){
        global $DB;
        $questions = array();
        foreach ($ids as $id){
            $param = array("id" => $id);
            $question = $DB->get_record("question", $param);

            // get option for question
            get_question_options($question, true);

            // get tag for question
            $tagQuestions = $this->loadTagQuestion($id);
            $tags = array();
            foreach($tagQuestions as $tagQuestion){
                array_push($tags, $tagQuestion->id_tag);
            }

            $question->tags = $tags;
            array_push($questions, $question);
        }
        return $questions;
    }

    public function loadByUser(){
        global $DB, $USER;
        $sql = 'SELECT * FROM '.$DB->get_prefix().'question WHERE createdby ='.$USER->id;
        $questions = $DB->get_records_sql($sql, array());
        return $questions;
    }
    public function delete($id){
        global $DB;
        $status = 0;

//        question_require_capability_on($id, 'edit');
        $tagQuestions = $this->loadTagQuestion($id);

        foreach($tagQuestions as $tagQuestion){
            $this->deleteTagQuestion($tagQuestion->id);
        }

        $tagQuestions = $this->loadTagQuestion($id);

        foreach($tagQuestions as $tagQuestion){
            $this->deleteTagQuestion($tagQuestion->id);
        }

        if (questions_in_use(array($id))) {
            $DB->set_field('question', 'hidden', 1, array('id' => $id));
        } else {
//            $DB->delete_records('question', array('id' => $id));
            question_delete_question($id);
        }
    }

    private function buildQuestionObject($wrongAnswers, $questionText, $answer, $categoryId, $qtype){
        $question = new stdClass();
        $question->category = $categoryId;

        $question->name = $questionText;
        $question->id = optional_param('id', "", PARAM_INT);
        $question->length = "1";
        $question->penalty = "0.3333333";
        $question->questiontext = array(text => $questionText, format => "1", defaultmark =>"1");
        $question->qtype = $qtype;
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