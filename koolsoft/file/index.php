<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/27/16
 * Time: 1:26 PM
 */

require_once(__DIR__.'/FileController.php');

$action = 'index';
$controller = new FileController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "index"){
    $controller->index();

} else if($action == "upload"){
    $controller->upload();

} else if($action == "download"){
    $controller->download();

} else if($action == "filesOfCourse"){
    $controller->filesOfCourse();
}