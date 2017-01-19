<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/13/17
 * Time: 1:16 AM
 */
header('Access-Control-Allow-Origin: *');

global $CFG;
require_once("../../../config.php");
require_once("rest_quiz.php");

$action  = optional_param('action', 0, PARAM_TEXT);
$controller = new rest_quiz();
switch ($action) {
    case "loadQuiz":
        $controller->loadQuiz();
        break;
    case "loadBySectionAndType":
        $controller->loadBySectionAndType();
        break;
    case "loadResultExerciseForUser":
        $controller->loadResultExerciseForUser();
        break;
   case "loadResultTestForUser":
        $controller->loadResultTestForUser();
        break;
    case "loadBySection":
        $controller->loadBySection();
        break;
}