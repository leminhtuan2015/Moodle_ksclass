<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 9:51 PM
 */

require_once(__DIR__.'/rest_question.php');

//error_log(print_r($_GET, true)); // $_POST or $_GET => is the data object of ajax

//error_log(print_r($_GET, true));

$controller = new rest_question();

$action  = optional_param('action', "", PARAM_TEXT);
error_log("dungdvaction".json_encode($action));
if($action == "create"){
	error_log("dungdv 2222question fff".json_encode(optional_param('questions', "", PARAM_TEXT)));
	error_log("dungdv 2222question fff".json_encode(optional_param('action', "", PARAM_TEXT)));
    $controller->create();

} else if($action == "edit") {
    $controller->edit();
} else if($action == "update"){
    $controller->update();

} else if($action == "listByTag"){
    $controller->getByTag();

} else if($action == "listByIds"){
    $controller->getByIds();

} else if($action == "one"){
    $controller->get();

} else if($action == "delete"){
    $controller->delete();

} else if($action == "show"){
    $controller->show();

} else if($action == "import"){
    $controller->import();
}