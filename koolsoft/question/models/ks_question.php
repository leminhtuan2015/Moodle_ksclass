<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/24/16
 * Time: 2:12 AM
 */

global $CFG;
require_once($CFG->dirroot."/config.php");
class ks_question
{
    function __construct() {

    }

    public function load_questions($categoryId){
        global $DB;
        $sql = 'SELECT * FROM ks_question WHERE category ='.$categoryId;
        $param = array();
        $questions = $DB->get_records_sql($sql, $param);
        return $questions;
    }

}