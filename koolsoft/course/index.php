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
    // Index
    $categoryid = optional_param('categoryid', "all", PARAM_INT);

    $controller->index($categoryid);
} else if($action == "show"){
    // Show
    $id = $_GET['id'];

    $controller->show($id);

} else if($action == "edit"){
    $id = optional_param('id', 0, PARAM_INT); // Course id.

    $controller->edit($id);

} else if($action == "myCourses"){
    // My course
}