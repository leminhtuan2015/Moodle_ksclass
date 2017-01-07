<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/22/16
 * Time: 8:35 AM
 */
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../mod/quiz/locallib.php");
require_once(__DIR__.'/../../course/modlib.php');
require_once(__DIR__.'/../../question/editlib.php');
require_once(__DIR__."/../application/ApplicationController.php");
require_once(__DIR__.'/models/ks_quiz.php');
require_once(__DIR__."/../../koolsoft/question_categories/models/ks_question_categories.php");

class QuizController extends ApplicationController{

    function __construct() {
        parent::__construct();
    }

    public function index() {
        require_once(__DIR__.'/views/index.php');
    }

    public function edit($courseid, $section, $lectureId, $id, $saveAction) {
        global $DB, $USER;
        $dao = new ks_quiz();
        $course = null;
        if($courseid){
            $course = $DB->get_record('course', array('id'=> $courseid), '*', MUST_EXIST);
        }
        if($saveAction && $saveAction == "saveQuiz"){
            $startTime = $_POST["startTime"];
            $endTime = $_POST["endTime"];
            $quizName = $_POST["nameQuiz"];
            $quizId = $_POST["idQuiz"];
            $quizDesc = $_POST["descQuiz"];
            $quizObject = $dao->getData($quizId, $quizName, $quizDesc, 0, 0, 0);

            $idQuestions = explode( ',', $_POST["idQuestions"]);
            $idSlotRemoves = explode( ',', $_POST["idSlotRemoves"]);

            $quizObject->sumgrades = count($idQuestions);
            $quizObject->grade = count($idQuestions);
            $quizObject->course = $courseid;
            $quizObject->section = $section;
            $quizObject->timeopen = DateUtil::getHumanDate($startTime);
            $quizObject->timeclose = DateUtil::getHumanDate($endTime);
            if(!$quizObject->id){
                $quiz = add_moduleinfo($quizObject, $course, null);
            }else {
                $quiz = $DB->get_record('quiz', array('id'=> $quizObject->id), '*', MUST_EXIST);
            }

            $quizdao = new ks_quiz();
            if(count($idQuestions) > 0){
                foreach ($idQuestions as $idQuestion){
                    if($idQuestion){
                        quiz_add_quiz_question($idQuestion, $quiz, 0);
                    }
                }
            }

            if(count($idSlotRemoves) > 0){
                foreach ($idSlotRemoves as $idSlotRemove){
                    if($idSlotRemove){
                        $quizdao->remove_slot($idSlotRemove);
                    }
                }
            }

            redirect("/moodle/koolsoft/course/?action=show&id=".$courseid);
        }
        $currentSection = null;
        if($section){
            $currentSection = $DB->get_record('course_sections', array('id'=> $lectureId), '*', MUST_EXIST);
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