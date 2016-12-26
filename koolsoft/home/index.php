<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:13 PM
 */

require_once(__DIR__.'/HomeController.php');

$action = 'index';
$controller = new HomeController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == "index"){
    $controller->index();

} else if($action == "show"){
    $id = $_GET['id'];

} else if($action == "myCourses"){

}