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
    // Index
    $categoryid = optional_param('category', "all", PARAM_INT);

    $controller->index($categoryid);
} else if($action == "show"){
    // Show
    $id = $_GET['id'];

    $controller->show($id);

} else if($action == "edit"){
    $idCategory = optional_param('category', 0, PARAM_INT); // Course id.

    $controller->edit($idCategory);

}
