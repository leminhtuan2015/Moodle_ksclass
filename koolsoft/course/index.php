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
    $controller->index();
} else if($action == "show"){
    // Show
    $id = $_GET['id'];

} else if($action == "myCourses"){
    // My course
}