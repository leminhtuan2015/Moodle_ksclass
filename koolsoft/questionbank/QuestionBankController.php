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

class QuestionBankController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index() {

        require_once(__DIR__.'/views/index.php');
    }
    public function show($categoryid, $courseid, $cat) {
        global $USER;
        if($categoryid == all){
            // TODO
        }else {
            $thiscontext = context_course::instance($courseid);
            if ($thiscontext) {
                $contexts = new question_edit_contexts($thiscontext);
            }else {
                $contexts = null;
            }
            $urlEdit = "/ksclass/koolsoft/question/?action=edit&category=".$categoryid;
            $catmenu = question_category_options($contexts->all(), false, 0, true);
            $questions = $this->load_questions($categoryid);
        }
        require_once(__DIR__.'/views/show.php');
    }

    public function load_questions($categoryId){
        global $DB;
        $sql = 'SELECT * FROM question WHERE category ='.$categoryId;
        $param = array();
        $questions = $DB->get_records_sql($sql, $param);
        return $questions;
    }

}