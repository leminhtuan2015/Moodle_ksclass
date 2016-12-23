<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/22/16
 * Time: 8:35 AM
 */
require_once("../../config.php");
require_once(__DIR__.'/../../course/modlib.php');
require_once(__DIR__.'/../../question/editlib.php');
require_once(__DIR__."/../application/ApplicationController.php");

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
            $course = $DB->get_record('course', array('id'=> $courseid), '*', MUST_EXIST);
            $quiz = add_moduleinfo($quizObject, $course, null);
            $idQuestions = explode( ',', $_POST["idQuestions"]);
            if(count($idQuestions) > 0){
                foreach ($idQuestions as $idQuestion){
                    quiz_add_quiz_question($idQuestion, $quiz, 0);
                }
            }
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