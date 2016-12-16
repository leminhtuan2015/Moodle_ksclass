<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/17/16
 * Time: 2:25 PM
 */

require_once(__DIR__.'/CategoryController.php');

$action = 'index';
$controller = new CategoryController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "index"){
    $controller->index();
} else if($action == "show"){
    // Show
    $id = $_GET['id'];

    $controller->show($id);

} else if($action == "edit"){
    $id = optional_param('id', 0, PARAM_INT);

    $controller->edit($id);
} else if($action == "create"){
    $controller->create();
}