<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/9/17
 * Time: 10:09 AM
 */

require_once("../../../config.php");
require_once($CFG->dirroot . "/koolsoft/test/rest/rest_exercise.php");

// action add, update, list, delete
$action = optional_param("action", "", PARAM_TEXT);
$controler = new rest_exercise();
switch ($action) {
    case "play":
        $controler->play();
        break;

    case "start":
        $controler->start();
        break;

    case "loadResult":
        $controler->loadResultByQuizId();
        break;

}


