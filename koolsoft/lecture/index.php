<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/22/16
 * Time: 1:47 PM
 */

require_once(__DIR__.'/LectureController.php');

$action = 'index';
$controller = new LectureController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "show"){
    $id = $_GET['id'];
    $courseId = $_GET['courseId'];

    $controller->show($id, $courseId);

} else if ($action == "new") {
    $controller->newLecture();

} else if($action == "create"){
    $controller->create();

} else if($action == "edit"){
    $controller->edit();

} else if($action == "update"){
    $controller->update();

}  else if($action == "delete"){
    $id = $_GET['id'];

    $controller->delete($id);

} else if($action == "newChapter"){
    $controller->newChapter();

} else if($action == "createChapter"){
    $controller->createChapter();
}
