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

} else if($action == "new"){
    $id = optional_param('id', 0, PARAM_INT); // Course id.

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
} else if($action == "deleteSection"){
    $id = $_GET['id'];

    $controller->deleteSection($id);
}else if ($action == "adddata") {
    $id = optional_param('idcourse',0,PARAM_INT);
    $lecture = optional_param('lecture',0,PARAM_INT);
    $add = optional_param('add','',PARAM_ALPHA);
    if($add == "label") {
        header('Location: ' . "/moodle/koolsoft/course/views/adddata/addlabel.php?idcourse=$id&lecture=$lecture&add=$add");
    }
}