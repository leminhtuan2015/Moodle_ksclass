<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:13 PM
 */

require_once(__DIR__.'/FrontendController.php');

$action = 'index';
$controller = new FrontendController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "index"){
    $controller->index();
}