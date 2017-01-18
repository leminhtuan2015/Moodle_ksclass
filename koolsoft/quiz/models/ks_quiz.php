<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/23/16
 * Time: 10:03 PM
 */
global $CFG;
require_once($CFG->dirroot."/config.php");
require_once($CFG->dirroot."/koolsoft/question/models/ks_question.php");
require_once($CFG->dirroot."/koolsoft/test/models/ks_question_progress.php");
require_once($CFG->dirroot."/koolsoft/utility/DateUtil.php");
class ks_quiz
{
    public function loadAll(){
        global $DB;
        $quizs = $DB->get_records_sql("SELECT * FROM quiz", array());
        return $quizs;
    }

    public function loadOne($id){
        global $DB;
        $quiz = $DB->get_record("quiz", array("id" => $id));
        return $quiz;
    }

    public function loadByCourse($courseId){
        global $DB;
        $quizs = $DB->get_records("quiz", array("course" => $courseId));
        return $quizs;
    }

    public function loadBySection($sectionId){
        global $DB;
        $sql = "SELECT distinct q.* FROM ".$DB->get_prefix()."quiz q inner JOIN ".$DB->get_prefix()."course_modules m ON q.course = m.course WHERE m.section = ?";
        $quizs = $DB->get_records_sql($sql, array("section" => $sectionId));
        return $quizs;
    }
    
    public function loadBySectionAndType($sectionId, $type){
    	global $DB;
    	$sql = "SELECT q.*, m.id as cmid  FROM ".$DB->get_prefix()."quiz q JOIN ".$DB->get_prefix()."course_modules m ON q.id = m.instance WHERE m.section = ? AND q.type = ?";
    	$quizs = $DB->get_records_sql($sql, array($sectionId, $type));
    	return $quizs;
    }

    public function removeSlot($slotId){
        global $DB;
        $DB->delete_records('quiz_slots', array('id' => $slotId));
    }

    public function removeAlllot($quizId){
        global $DB;
        $slots = $this->loadSlotsInQuiz($quizId);
        foreach ($slots as $slot){
            $this->removeSlot($slot->slotid);
        }
    }

    public function checkSlot($questionId, $quizId){
        global $DB;
        $slot = $DB->get_record('quiz_slots', array('quizid' => $quizId, "questionid" => $quizId));
        if($slot){
            return true;
        }else {
            return false;
        }
    }

    public function loadOneWithQuestion($id){
        global $DB;
        $quiz = $DB->get_record("quiz", array("id" => $id));
        $quetions = $this->loadQuestionByQuiz($id);
        $quiz->questions = $quetions;
        $quiz->numberQuestion = count($quetions);
        return $quiz;
    }

    public function loadQuestionByQuiz($id){
        $daoQuestion = new ks_question();
        $slots = $this->loadSlotsInQuiz($id);
        $idQuestions = array();
        foreach ($slots as $slot){
            array_push($idQuestions, $slot->questionid);
        }

        $questions = $daoQuestion->getByIds($idQuestions);

        return $questions;
    }

    public function loadSlotsInQuiz($id){
        global $DB;
        $slots = $DB->get_records_sql("
                SELECT slot.id AS slotid, slot.slot, slot.questionid, slot.page, slot.maxmark,
                        slot.requireprevious, q.*
                  FROM {quiz_slots} slot
                  JOIN {question} q ON q.id = slot.questionid
                 WHERE slot.quizid = ?
              ORDER BY slot.slot", array($id));
        return $slots;
    }

    public function loadSlotsOnlyInQuiz($id){
        global $DB;
        $slots = $DB->get_records("quiz_slots", array("quizid" => $id));
        return $slots;
    }

    public function loadAllResultTestForUser($idCourse, $idUser){
        global $DB;
        $sql = "SELECT q.id, q.name, q.sumgrades,a.sumgrades as grade, a.state, a.timefinish  FROM ".$DB->get_prefix()."quiz q "
                    ."INNER JOIN ".$DB->get_prefix()."quiz_attempts a ON q.id = a.quiz WHERE a.userid = ".$idUser." AND q.course = ".$idCourse + "q.type = 2";
        $quizResults = $DB->get_records_sql($sql, array());
        foreach($quizResults as $quizResult){
            $quizResult->timefinish = DateUtil::todayHuman($quizResult->timefinish);
        }
        return $quizResults;
    }
    
    public function loadAllResultExerciseForUser($idCourse, $idUser){
    	global $DB;
    	$daoQuestionProgress = new ks_question_progress();
    	$sql = "SELECT q.id, q.name, q.grade  FROM ".$DB->get_prefix()."quiz q "
    			."INNER JOIN ".$DB->get_prefix()."quiz_attempts a ON q.id = a.quiz WHERE a.userid = ".$idUser." AND q.course = ".$idCourse + "q.type = 1";
    	$quizResults = $DB->get_records_sql($sql, array());
    	foreach($quizResults as $quizResult){
    		$quizResult->timefinish = DateUtil::todayHuman($quizResult->timefinish);
    		$numberQuestionCompleted = $daoQuestionProgress->countCompleted($idUser, $quizResult->id, 4);
    		$quizResult->progess = intval($numberQuestionCompleted / intval($quizResult->grade));
    	}
    	return $quizResults;
    }

    public function getData($quizId, $quizName, $quizDesc, $startTime, $endTime, $currentSection, $courseid, $sumgrades, $grade,  $timeLimit, $type){
        $quizObject = new stdClass();
        $quizObject->name = $quizName;
        $quizObject->id = $quizId;
        $quizObject->introeditor= array( "text" => $quizDesc, "format" => 1);

        $quizObject->timeopen = $startTime;
        $quizObject->timeclose = $endTime;
        $quizObject->timelimit = $timeLimit;
        $quizObject->overduehandling = "autosubmit";
        $quizObject->graceperiod = 0;
        $quizObject->gradecat = 2;
        $quizObject->grade = $grade;
        $quizObject->sumgrades = $sumgrades;
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
        $quizObject->course = $courseid;
        $quizObject->coursemodule = 0;
        $quizObject->section = $currentSection;
        $quizObject->module = 16;
        $quizObject->modulename = "quiz";
        $quizObject->instance = 0;
        $quizObject->add = "quiz";
        $quizObject->update = 0;
        $quizObject->return = 0;
        $quizObject->sr = 4;
        $quizObject->competency_rule = 0;
        $quizObject->submitbutton = "Save and display";
        $quizObject->type = $type;

        return $quizObject;
    }
}