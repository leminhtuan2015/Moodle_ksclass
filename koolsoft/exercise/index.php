<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/3/17
 * Time: 11:12 AM
 */

require_once("ExerciseController.php");
$action = 'index';
$controller = new TestController();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

