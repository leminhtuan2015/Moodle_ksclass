<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/3/17
 * Time: 11:12 AM
 */

require_once("./TestController.php");
$action = 'index';
$controller = new TestController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "index"){
    $controller->startTest();
}else if($action == "play"){
    $controller->play();
}else if($action == "process"){
    $controller->process();
}else if($action == "review"){
    $controller->review();
}