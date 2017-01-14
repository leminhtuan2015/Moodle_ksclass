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
require_once(__DIR__."/models/ks_question.php");
require_once($CFG->dirroot."/koolsoft/question_categories/models/ks_question_categories.php");

class QuestionController extends ApplicationController {
    public static $EMPTY_QUESTION = "ks_mark_emptyquestion_1108";

    function __construct() {
        parent::__construct();
    }

    public function index($idCategory) {
        global $DB, $USER;

        $daoQuestionCategories = new ks_question_categories();
        $returnUrl = optional_param("returnUrl", "", PARAM_TEXT);
        $category = $daoQuestionCategories->loadCategory($idCategory);

        $count = $DB->count_records('question', array('createdby' => $USER->id));
        $pageZise = $count/20;

        require_once(__DIR__.'/views/index.php');
    }

}