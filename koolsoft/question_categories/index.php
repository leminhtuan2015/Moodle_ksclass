<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/27/16
 * Time: 9:27 AM
 */

require_once(__DIR__."/QuestionCategoryController.php");

$action = 'index';
$controller = new QuestionCategoryController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
if($action == "index"){
    $idCategory = optional_param('id', 0, PARAM_INT);
    $controller->index($idCategory);

}
