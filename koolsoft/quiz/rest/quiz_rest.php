<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/23/16
 * Time: 3:28 PM
 */
if (!defined('AJAX_SCRIPT')) {
    define('AJAX_SCRIPT', true);
}
require_once("../../../config.php");
require_once("../../quiz/models/ks_quiz.php");

$action  = optional_param('action', 0, PARAM_TEXT);
$dao = new ks_quiz();

switch ($action) {
    case "loadQuiz":
        $quizid  = optional_param('quizId', 0, PARAM_INT);
        $quiz = $dao->loadOneWithQuestion($quizid);
        echo json_encode($quiz);
        break;
    case "loadAllResultQuizForUser":
        $idUser  = optional_param('idUser', 0, PARAM_INT);
        $idCourse = optional_param('idCourse', 0, PARAM_INT);
        $quizReslut = $dao->loadAllResultQuizForUser($idCourse, $idUser);
        echo json_encode($quizReslut);
    break;
}


