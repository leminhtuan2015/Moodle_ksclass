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

$action  = optional_param('action', 0, PARAM_TEXT);

if($action == "create"){
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
}