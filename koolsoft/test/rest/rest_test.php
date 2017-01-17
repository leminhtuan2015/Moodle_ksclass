<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/13/17
 * Time: 12:13 AM
 */

global $CFG;
require_once($CFG->dirroot . "/config.php");
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->dirroot . '/koolsoft/quiz/models/ks_quiz.php');
require_once($CFG->dirroot . '/koolsoft/test/models/ks_question_progress.php');
require_once($CFG->dirroot . '/koolsoft/question/models/ks_question.php');
require_once($CFG->dirroot . '/koolsoft/quiz/models/ks_quiz.php');
require_once($CFG->dirroot . '/koolsoft/utility/DateUtil.php');

class rest_test
{
    public function play(){
        $attemptid = required_param('attempt',  PARAM_INT);
        if($this->submitPlay()){
            $resultObject = $this->loadResultByAttemptId($attemptid);
            echo json_encode($resultObject);
            return;
        }else {
            $resultObject = new stdClass();
            echo json_encode($resultObject);
            return;
        }

    }

    public function start(){
        $startObject = $this->startPlay();
        $playObject = $this->loadForPlay($startObject->id);
        echo json_encode($playObject);
        return;
    }

    public function submitPlay(){
        global $USER;
        
    	if(!$USER->id){
        	$userId     = required_param('user',  PARAM_INT);
        	$USER = new stdClass();
        	$USER->id = $userId;
        }
        
        $daoQuestionProgress = new ks_question_progress();
        $timenow = time();

        $attemptid     = required_param('attempt',  PARAM_INT);
        $thispage      = optional_param('thispage', 0, PARAM_INT);
        $nextpage      = optional_param('nextpage', 0, PARAM_INT);
        $previous      = optional_param('previous',      false, PARAM_BOOL);
        $next          = optional_param('next',          false, PARAM_BOOL);
        $finishattempt = optional_param('finishattempt', false, PARAM_BOOL);
        $timeup        = optional_param('timeup',        0,      PARAM_BOOL); // True if form was submitted by timer.
        $scrollpos     = optional_param('scrollpos',     '',     PARAM_RAW);

        $attemptobj = quiz_attempt::create($attemptid);
        $status = $attemptobj->process_attempt($timenow, $finishattempt, $timeup, $thispage);
        $slots = $attemptobj->get_slots();
        foreach ($slots as $slot){
            $questionAttempt = $attemptobj->get_question_attempt($slot);
            $daoQuestionProgress->update($USER->id, $attemptobj->get_quizid(), $questionAttempt->get_question()->id, $questionAttempt->get_fraction());
        }

        return  true;
    }

    public function startPlay(){
        global $USER, $DB;
        
    	if(!$USER->id){
        	$userId     = required_param('user',  PARAM_INT);
        	$USER = new stdClass();
        	$USER->id = $userId;
        }

        // Get submitted parameters.
        $id = required_param('cmid', PARAM_INT); // Course module id
        $forcenew = optional_param('forcenew', false, PARAM_BOOL); // Used to force a new preview
        $page = optional_param('page', -1, PARAM_INT); // Page to jump to in the attempt.

        if (!$cm = get_coursemodule_from_id('quiz', $id)) {
            print_error('invalidcoursemodule');
        }

        if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
            print_error("coursemisconf");
        }

        $quizobj = quiz::create($cm->instance, $USER->id);

        // Create an object to manage all the other (non-roles) access rules.
        $timenow = time();
        $accessmanager = $quizobj->get_access_manager($timenow);

        // Validate permissions for creating a new attempt and start a new preview attempt if required.
        list($currentattemptid, $attemptnumber, $lastattempt, $messages, $page) =
            quiz_validate_new_attempt($quizobj, $accessmanager, $forcenew, $page, true);

        $attempt = quiz_prepare_and_start_new_attempt($quizobj, $attemptnumber, $lastattempt);
        $result = new stdClass();
        $result->id = $attempt->id;
        return $result;
    }

    public function loadForPlay($id){
        global $DB;
        $daoQuestion = new ks_question();
        $daoQuiz = new ks_quiz();
        $attempt = $DB->get_record("quiz_attempts", array("id" => $id));
        $quiz = $daoQuiz->loadOne($attempt->quiz);
        $quizName = $quiz->name;
        $attemptobj = quiz_attempt::create($id);
        $slots = $daoQuiz->loadSlotsInQuiz($attempt->quiz);
        $sequenceChecks = array();
        $slotString = "";
        $indexSlot = 0;
        $questions = array();
        foreach ($slots as $slot){
            $question_attempts = $attemptobj->all_question_attempts_originally_in_slot($slot->slot);
            $orderAnswer = $attemptobj->get_question_attempt($slot->slot)->get_step(0)->get_all_data();
            $question = $attemptobj->get_question_attempt($slot->slot)->get_question();
            $answerIds = explode( ',',$orderAnswer["_order"]);
            $answers = array();
            $answerNoOrders = $question->answers;
            foreach ($answerIds as $answerId){
                array_push($answers, $answerNoOrders[$answerId]);
            }
            $question->answers = $answers;
            array_push($questions, $question);

            $question_attempt = $question_attempts[0];
            array_push($sequenceChecks, $question_attempt->get_sequence_check_count());
            if($indexSlot == 0){
                $slotString .= $slot->slot;
            }else {
                $slotString .= ",".$slot->slot;
            }
            $indexSlot ++;
        }

        $attempt->questions = $questions;
        $attempt->sequenceChecks = $sequenceChecks;
        $attempt->slotString = $slotString;
        $attempt->quiz = $quiz;

        return $attempt;
    }

    public function loadResultByQuizId(){
        global  $DB, $USER;
        
    	if(!$USER->id){
        	$userId     = required_param('user',  PARAM_INT);
        	$USER = new stdClass();
        	$USER->id = $userId;
        }

        $quizId = optional_param('quiz', 0, PARAM_INT);

        $quizAttempt = $DB->get_record("quiz_attempts", array("quiz" => $quizId));

        // when quiz not finished
        if(!$quizAttempt || $quizAttempt->state != quiz_attempt::FINISHED){
            $daoQuiz = new ks_quiz();
            $quiz = $daoQuiz->loadOneWithQuestion($quizId);
            $quiz->timelimit = $quiz->timelimit / 60;
            $quiz->timeopen = DateUtil::getHumanDate($quiz->timeopen);
            $quiz->timeclose = DateUtil::getHumanDate($quiz->timeclose);
            echo json_encode($quiz);
            return;
        }else {
            echo json_encode($this->loadResultByAttemptId($quizAttempt->id));
        }
    }

    public function loadResultByAttemptId($attemptid){
        global  $DB, $USER;
        
    	if(!$USER->id){
        	$userId     = required_param('user',  PARAM_INT);
        	$USER = new stdClass();
        	$USER->id = $userId;
        }

        $page      = optional_param('page', 0, PARAM_INT);
        $showall   = optional_param('showall', true, PARAM_BOOL);

        $attemptobj = quiz_attempt::create($attemptid);
        $page = $attemptobj->force_page_number_into_range($page);
        $questionids = $attemptobj->get_slots();

        // Work out some time-related things.
        $attempt = $attemptobj->get_attempt();
        $quiz = $attemptobj->get_quiz();
        $options = $attemptobj->get_display_options(true);

        // get question data for show result
        $slots = $attemptobj->get_slots();
        $questions = array();

        foreach ($slots as $slot){
            $questionAttempt = $attemptobj->get_question_attempt($slot);
            $choiceAnswerObject = $questionAttempt->get_step(1)->get_all_data();
            $orderAnswer = $questionAttempt->get_step(0)->get_all_data();
            $question = $questionAttempt->get_question();
            $answerIds = explode( ',',$orderAnswer["_order"]);
            $choiceAnswer = $choiceAnswerObject["answer"];
            $answers = array();
            $answerNoOrders = $question->answers;
            $indexAnswer = 0;
            foreach ($answerIds as $answerId){
                $answer = $answerNoOrders[$answerId];
                if($indexAnswer == $choiceAnswer){
                    $answer->answered = true;
                }

                if($answer->fraction > 0){
                    $answer->correct = true;
                }
                array_push($answers, $answer);
                $indexAnswer ++;
            }
            $question->answers = $answers;
            array_push($questions, $question);
        }

        $quiz->timestart = DateUtil::getHumanDate($attempt->timestart);
        $quiz->timefinish = DateUtil::getHumanDate($attempt->timefinish);
        $quiz->timeTaken = ($quiz->timestart - $quiz->timefinish) / 60;
        $quiz->questions= $questions;
        $quiz->sumgradeUsers= intval($attempt->sumgrades);
        $quiz->sumgrades= intval($quiz->sumgrades);
        if(($quiz->sumgradeUsers / $quiz->sumgrades) >= 0.5){
        	$quiz->pass = true;
        }else {
        	$quiz->pass = false;
        }
        $quiz->numberQuestion= count($questions);
        $quiz->state = true;// finished test
        $quiz->timelimit = $quiz->timelimit / 60;
        $quiz->timeopen = DateUtil::getHumanDate($quiz->timeopen);
        $quiz->timeclose = DateUtil::getHumanDate($quiz->timeclose);

        return $quiz;
    }

}