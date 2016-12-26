<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 9:51 PM
 */

require_once(__DIR__.'/CourseController.php');

$action = 'index';
$controller = new CourseController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "index"){
    $categoryid = optional_param('categoryid', "all", PARAM_INT);

    $controller->index($categoryid);

} else if($action == "show"){
    $id = $_GET['id'];

    $controller->show($id);

} else if($action == "new"){
    $id = optional_param('id', 0, PARAM_INT);

    $controller->newCourse($id);

} else if($action == "myCourses"){
    $controller->myCourse();

} else if($action == "create"){
    $controller->create();

} else if($action == "edit"){
    $id = $_GET['id'];
    $controller->edit($id);

} else if($action == "update"){
    $controller->update();

} else if($action == "delete"){
    $id = $_GET['id'];

    $controller->delete($id);

}