<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/3/17
 * Time: 8:22 PM
 */

require_once(__DIR__."/QuestionTagController.php");

$action = 'show';
$controller = new QuestionTagController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
if($action == "show"){
    $controller->show();
}
