<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/15/16
 * Time: 9:51 PM
 */


require_once("./QuestionController.php");

$action = 'index';
$controller = new QuestionController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "index"){
    $idCategory = optional_param('category', 0, PARAM_INT); // Course id.

    $controller->index($idCategory);
}
