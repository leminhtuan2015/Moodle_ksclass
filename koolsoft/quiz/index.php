<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/22/16
 * Time: 8:35 AM
 */
require_once("./QuizController.php");

$action = 'index';
$controller = new QuizController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "index"){
    // Index

} else if($action == "show"){
    // Show

} else if($action == "edit"){
    $course = optional_param('course', 0, PARAM_INT);
    $section = optional_param('section', 0, PARAM_INT);
    $id = optional_param('id', 0, PARAM_INT);
    $saveAction = optional_param('saveAction', 0, PARAM_TEXT);
    $controller->edit($course, $section, $id, $saveAction);
}
