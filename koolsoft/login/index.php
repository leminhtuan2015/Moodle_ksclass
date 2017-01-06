<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 9:51 PM
 */

require_once(__DIR__.'/LoginController.php');

$action = 'index';
$controller = new LoginController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "index"){
    $controller->index();

} else if($action == "login"){

    $controller->login();

} else if($action == "new"){
    $controller->newRegister();
}