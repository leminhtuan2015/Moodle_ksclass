<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:13 PM
 */

require_once(__DIR__.'/SearchController.php');

$action = 'index';
$controller = new SearchController();

$keyword = optional_param('search', "", PARAM_TEXT);

if($keyword){
    $action = 'show';
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "index"){
    // Index
    $controller->index();
} else if($action == "show"){
    // Show
    $id = $_GET['id'];

    $controller->show($keyword);

}