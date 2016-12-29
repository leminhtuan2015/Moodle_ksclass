<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/23/16
 * Time: 10:03 PM
 */
global $CFG;
require_once($CFG->dirroot."/config.php");
class ks_quiz
{
    public function remove_slot($slotId){
        global $DB;
        $DB->delete_records('quiz_slots', array('id' => $slotId));
    }

    public function load_slots_in_quiz($id){
        global $DB;
        $slots = $DB->get_records_sql("
                SELECT slot.id AS slotid, slot.slot, slot.questionid, slot.page, slot.maxmark,
                        slot.requireprevious, q.*, qc.contextid
                  FROM {quiz_slots} slot
                  LEFT JOIN {question} q ON q.id = slot.questionid
                  LEFT JOIN {question_categories} qc ON qc.id = q.category
                 WHERE slot.quizid = ?
              ORDER BY slot.slot", array($id));
        return $slots;
    }

    public function getData($quizId, $quizName, $quizDesc, $startTime, $endTime, $timeLimit){
        $quizObject = new stdClass();
        $quizObject->name = $quizName;
        $quizObject->id = $quizId;
        $quizObject->introeditor= array( "text" => $quizDesc, "format" => 1);

        $quizObject->timeopen = $startTime;
        $quizObject->timeclose = $endTime;
        $quizObject->timelimit = 0;
        $quizObject->overduehandling = "autosubmit";
        $quizObject->graceperiod = 0;
        $quizObject->gradecat = 2;
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