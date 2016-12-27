<?php
/**
 * Created by PhpStorm.
 * User: xuan
 * Date: 27/12/2016
 * Time: 14:07
 */
require_once(__DIR__.'/AdminController.php');
$action = 'index';
$controller = new AdminController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "index") {
    $controller->index();
}else if($action == "listuser") {
    $controller->show_list_user();
}else if($action == "adduser") {
    $controller->add_new_user();
}
