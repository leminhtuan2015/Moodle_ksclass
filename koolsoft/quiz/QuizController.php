<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/22/16
 * Time: 8:35 AM
 */
require_once("../../config.php");
require_once("../../mod/quiz/locallib.php");
require_once(__DIR__.'/../../course/modlib.php');
require_once(__DIR__.'/../../question/editlib.php');
require_once(__DIR__."/../application/ApplicationController.php");
require_once(__DIR__.'/models/ks_quiz.php');

class QuizController extends ApplicationController{

    function __construct() {
        parent::__construct();
    }

    public function index() {
        require_once(__DIR__.'/views/index.php');
    }

    public function edit($courseid, $section, $id, $saveAction) {
        global $DB;
        if($saveAction && $saveAction == "saveQuiz"){
            $quizObject = $this->getData();
            $idQuestions = explode( ',', $_POST["idQuestions"]);
            $idSlotRemoves = explode( ',', $_POST["idSlotRemoves"]);

            $quizObject->sumgrades = count($idQuestions);
            $quizObject->grade = count($idQuestions);
            if(!$quizObject->id){
                $course = $DB->get_record('course', array('id'=> $courseid), '*', MUST_EXIST);
                $quiz = add_moduleinfo($quizObject, $course, null);
            }else {
                $quiz = $DB->get_record('quiz', array('id'=> $quizObject->id), '*', MUST_EXIST);
            }

            $quizdao = new ks_quiz();
            if(count($idQuestions) > 0){
                foreach ($idQuestions as $idQuestion){
                    if($idQuestion){
                        quiz_add_quiz_question($idQuestion, $quiz, 0);
                    }
                }
            }

            if(count($idSlotRemoves) > 0){
                foreach ($idSlotRemoves as $idSlotRemove){
                    var_dump("fff".$idSlotRemove);
                    if($idSlotRemove){
                        var_dump("ffsdf");
                        $quizdao->remove_slot($idSlotRemove);
                    }
                }
            }

            echo "<script type='text/javascript'> window.location.replace('"."/moodle/koolsoft/lecture/?action=show&id=".$section."&courseId=".$courseid."')</script>";
        }
        $currentQuiz = null;
        if($id){
            $currentQuiz = $DB->get_record('quiz', array('id'=> $id), '*', MUST_EXIST);
        }
        //load category question bank
        $thiscontext = context_course::instance($courseid);
        if ($thiscontext) {
            $contexts = new question_edit_contexts($thiscontext);
        }else {
            $contexts = null;
        }
        $catmenu = question_category_options($contexts->all(), false, 0, true);

        require_once(__DIR__.'/views/edit.php');
    }

    public function getData(){
        $quizObject = new stdClass();
        $quizObject->name = $_POST["nameQuiz"];
        $quizObject->id = $_POST["idQuiz"];
        $quizObject->introeditor= array( "text" => $_POST["descQuiz"], "format" => 1);

        $quizObject->timeopen = 0;
        $quizObject->timeclose = 0;
        $quizObject->timelimit = 0;
        $quizObject->overduehandling = "autosubmit";
        $quizObject->graceperiod = 0;
        $quizObject->gradecat = 2;
//    $quizObject->gradepass =
        $quizObject->grade = 10;
        $quizObject->sumgrades = 10;
        $quizObject->attempts = 0;
        $quizObject->grademethod = 1;
        $quizObject->questionsperpage = 1;
        $quizObject->navmethod = "free";
        $quizObject->shuffleanswers = 1;
        $quizObject->preferredbehaviour = "deferredfeedback";
        $quizObject->canredoquestions = 0;
        $quizObject->attemptonlast = 0;
        $quizObject->attemptimmediately = 1;
        $quizObject->correctnessimmediately = 1;
        $quizObject->marksimmediately = 1;
        $quizObject->specificfeedbackimmediately = 1;
        $quizObject->generalfeedbackimmediately = 1;
        $quizObject->rightanswerimmediately = 1;
        $quizObject->overallfeedbackimmediately = 1;
        $quizObject->attemptopen = 1;
        $quizObject->correctnessopen = 1;
        $quizObject->marksopen = 1;
        $quizObject->specificfeedbackopen = 1;
        $quizObject->generalfeedbackopen = 1;
        $quizObject->rightansweropen = 1;
        $quizObject->overallfeedbackopen = 1;
        $quizObject->attemptclosed = 1;
        $quizObject->correctnessclosed = 1;
        $quizObject->marksclosed = 1;
        $quizObject->specificfeedbackclosed = 1;
        $quizObject->generalfeedbackclosed = 1;
        $quizObject->rightanswerclosed = 1;
        $quizObject->overallfeedbackclosed = 1;
        $quizObject->showuserpicture = 0;
        $quizObject->decimalpoints = 2;
        $quizObject->questiondecimalpoints = -1;
        $quizObject->showblocks = 0;
        $quizObject->quizpassword = "";
        $quizObject->subnet = "";
        $quizObject->delay1 = 0;
        $quizObject->delay2 = 0;
        $quizObject->browsersecurity = "securewindow";
        $quizObject->boundary_repeats = 0;
        $quizObject->feedbacktext = array("0" => array("text" => "", "format" => 1));

        $quizObject->visible = 1;
        $quizObject->cmidnumber = "";
        $quizObject->groupmode = 1;
        $quizObject->groupingid = 0;
        $quizObject->availabilityconditionsjson = array();
        $quizObject->completionunlocked = 1;
        $quizObject->completion = 1;
        $quizObject->completionpass = 0;
        $quizObject->completionattemptsexhausted = 0;
        $quizObject->completionexpected = 0;
        $quizObject->tags = "";
        $quizObject->course = 3;
        $quizObject->coursemodule = 0;
        $quizObject->section = 4;
        $quizObject->module = 16;
        $quizObject->modulename = "quiz";
        $quizObject->instance = 0;
        $quizObject->add = "quiz";
        $quizObject->update = 0;
        $quizObject->return = 0;
        $quizObject->sr = 4;
        $quizObject->competency_rule = 0;
        $quizObject->submitbutton = "Save and display";

        return $quizObject;
    }

}