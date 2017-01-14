<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 9:51 PM
 */

require_once(__DIR__.'/DiscussionController.php');

$action = 'index';
$controller = new DiscussionController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "create"){
    $controller->create();
}