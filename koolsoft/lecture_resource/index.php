<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/23/16
 * Time: 2:16 PM
 */

require_once(__DIR__.'/LectureResourceController.php');

$action = 'index';
$controller = new LectureResourceController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if ($action == "new") {
    $controller->newResouce();

} else if($action == "create"){
    $controller->create();

} else if($action == "edit"){
    $controller->edit();

} else if($action == "update"){
    $controller->update();
}