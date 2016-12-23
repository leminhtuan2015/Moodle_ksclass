<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/23/16
 * Time: 9:01 AM
 */
//require_once("../../../config.php");
global $CFG;
require_once($CFG->dirroot."/config.php");
class dao
{
    function __construct() {

    }

    public function load_questions($categoryId){
        global $DB;
        $sql = 'SELECT * FROM question WHERE category ='.$categoryId;
        $param = array();
        $questions = $DB->get_records_sql($sql, $param);
        return $questions;
    }

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
}