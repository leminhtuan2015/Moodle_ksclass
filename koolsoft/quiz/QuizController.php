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
        if($saveAction && $saveAction == "saveQuiz"){
            $startTime = $_POST["startTime"];
            $endTime = $_POST["endTime"];
            $quizName = $_POST["nameQuiz"];
            $quizId = $_POST["idQuiz"];
            $quizDesc = $_POST["descQuiz"];
            $quizObject = $dao->getData($quizId, $quizName, $quizDesc, 0, 0, 0);

            $idQuestions = explode( ',', $_POST["idQuestions"]);

            $quizObject->sumgrades = count($idQuestions);
            $quizObject->grade = count($idQuestions);
            $quizObject->course = $courseid;
            $quizObject->section = $currentSection->section;
            $quizObject->timeopen = DateUtil::getHumanDate($startTime);
            $quizObject->timeclose = DateUtil::getHumanDate($endTime);
            if(!$quizObject->id){
                $quiz = add_moduleinfo($quizObject, $course, null);
            }else {
                $quiz = $dao->loadOne($quizObject->id);
                $course = CourseUtil::getCourse($quiz->course);
                $cm = $DB->get_record('course_modules', array('instance'=> $quiz->id), '*', MUST_EXIST);
                $quizObject->id = $quiz->id;
                $quizObject->instance = $quiz->id;
                $quizObject->coursemodule = $cm->id;
                $cm->modname = $quiz->name;
                $cm->section = $currentSection->id;
                update_moduleinfo($cm, $quizObject, $course);
            }

            $quizdao = new ks_quiz();
            //delete all slot old
            $quizdao->removeAlllot($quiz->id);

            if(count($idQuestions) > 0){
                foreach ($idQuestions as $idQuestion){
                    if($idQuestion){
                        quiz_add_quiz_question($idQuestion, $quiz, 0);
                    }
                }
            }

            redirect("/moodle/koolsoft/course/?action=show&id=".$courseid);
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



}