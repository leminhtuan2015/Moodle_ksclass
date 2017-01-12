<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/22/16
 * Time: 8:35 AM
 */
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../mod/quiz/locallib.php");
require_once(__DIR__.'/../../course/lib.php');
require_once(__DIR__.'/../../course/modlib.php');
require_once(__DIR__.'/../../question/editlib.php');
require_once(__DIR__."/../application/ApplicationController.php");
require_once(__DIR__.'/models/ks_quiz.php');
require_once(__DIR__."/../../koolsoft/question_categories/models/ks_question_categories.php");
require_once($CFG->dirroot . '/koolsoft/course/models/CourseUtil.php');

class QuizController extends ApplicationController{

    function __construct() {
        parent::__construct();
    }

    public function index() {
        require_once(__DIR__.'/views/index.php');
    }

    public function edit($courseid, $sectionId, $id, $saveAction) {
        global $DB, $USER;
        $dao = new ks_quiz();
        $course = null;
        if($courseid){
            $course = $DB->get_record('course', array('id'=> $courseid), '*', MUST_EXIST);
        }
        $currentSection = null;
        if($sectionId){
            $currentSection = $DB->get_record('course_sections', array('id'=> $sectionId), '*', MUST_EXIST);
        }

        $currentQuiz = null;
        if($id){
            $currentQuiz = $DB->get_record('quiz', array('id'=> $id), '*', MUST_EXIST);
        }
        //load category question
        $daoQuestionCategories = new ks_question_categories();
        $categories = $daoQuestionCategories->loadCategoryByTypeAndUser(2, $USER->id);

        require_once(__DIR__.'/views/edit.php');
    }

    public function save($courseid, $sectionId, $id) {
        global $DB, $USER;
        $dao = new ks_quiz();
        $course = null;
        if($courseid){
            $course = $DB->get_record('course', array('id'=> $courseid), '*', MUST_EXIST);
        }
        $currentSection = null;
        if($sectionId){
            $currentSection = $DB->get_record('course_sections', array('id'=> $sectionId), '*', MUST_EXIST);
        }
        $quizId = $_POST["idQuiz"];
        $typeQuiz = $_POST["typeQuiz"];
        $timeLimit = $_POST["timeLimit"];
        if(!$timeLimit){
            $timeLimit = 0;
        }else {
            $timeLimit = $timeLimit * 60;
        }

        $startTime = $_POST["startTime"];
        $endTime = $_POST["endTime"];
        $quizName = $_POST["nameQuiz"];
        $quizDesc = $_POST["descQuiz"];
        $idQuestions = explode( ',', $_POST["idQuestions"]);
        $sumgrades = count($idQuestions);
        $grade = count($idQuestions);
        $quizObject = $dao->getData(null, $quizName, $quizDesc, DateUtil::getTimestamp($startTime), DateUtil::getTimestamp($endTime), $currentSection->section, $courseid, $sumgrades, $grade,  $timeLimit, $typeQuiz);
        if(!$quizId){
            $quiz = add_moduleinfo($quizObject, $course, null);
        }else {
            $cm = $DB->get_record('course_modules', array('instance'=> $quizId), '*', MUST_EXIST);
            course_delete_module($cm->id, false);
            $quiz = add_moduleinfo($quizObject, $course, null);
        }

        $quizdao = new ks_quiz();

        if(count($idQuestions) > 0){
            foreach ($idQuestions as $idQuestion){
                if($idQuestion){
                    quiz_add_quiz_question($idQuestion, $quiz, 0);
                }
            }
        }

        redirect("/moodle/koolsoft/course/?action=show&id=".$courseid);
    }

}