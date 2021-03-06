<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/23/16
 * Time: 3:28 PM
 */
require_once("../../../config.php");
require_once("../../quiz/models/ks_quiz.php");

class rest_quiz {
    public function loadQuiz(){
        $dao = new ks_quiz();
        $quizid  = optional_param('quizId', 0, PARAM_INT);
        $quiz = $dao->loadOneWithQuestion($quizid);
        $quiz->timelimit = $quiz->timelimit / 60;
        $quiz->timeopen = DateUtil::getHumanDate($quiz->timeopen);
        $quiz->timeclose = DateUtil::getHumanDate($quiz->timeclose);
        echo json_encode($quiz);
    }
    
    public function loadBySectionAndType(){
    	$dao = new ks_quiz();
    	$sectionId = optional_param('section', 0, PARAM_INT);
    	$type = optional_param('type', 0, PARAM_INT);
    	
    	$quizs = $dao->loadBySectionAndType($sectionId, $type);
    	echo json_encode($quizs);
    }

    public function loadResultTestForUser(){
        $dao = new ks_quiz();
        $idUser  = optional_param('idUser', 0, PARAM_INT);
        $idCourse = optional_param('idCourse', 0, PARAM_INT);
        $quizResultTest = $dao->loadAllResultTestForUser($idCourse, $idUser);
        echo json_encode($quizResultTest);
    }
    
    public function loadResultExerciseForUser(){
    	$dao = new ks_quiz();
    	$idUser  = optional_param('idUser', 0, PARAM_INT);
    	$idCourse = optional_param('idCourse', 0, PARAM_INT);
    	$quizResultExercise = $dao->loadAllResultExerciseForUser($idCourse, $idUser);
    	echo json_encode($quizResultExercise);
    }

    public function loadBySection(){
        $dao = new ks_quiz();
        $sectionId  = optional_param('section', 0, PARAM_INT);
        $quizs= $dao->loadBySection($sectionId);
        echo json_encode($quizs);
    }
}


