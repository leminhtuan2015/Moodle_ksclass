<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/9/17
 * Time: 10:09 AM
 */

require_once("../../../config.php");
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->dirroot . '/koolsoft/test/TestController.php');

global $DB;
$dao = new ks_question();

// action add, update, list, delete
$action = optional_param('action', "", PARAM_TEXT);
global $USER;
$controler = new TestController();
switch ($action) {
    case "loadForPlay":
        echo json_encode($controler->loadForPlay());
        break;

    case "submitPlay":
        $attemptid     = required_param('attempt',  PARAM_INT);
        if($controler->submitPlay()){
            $resultObject = $controler->loadResult($attemptid);
            $resultObject->typeResult = "review";
        }else {
            $resultObject = new stdClass();
            $resultObject->typeResult = "error";
        }
        echo json_encode($resultObject);
        break;

    case "startPlay":
        $startObject = $controler->startPlay();
        if($startObject->status == "done"){
            $reviewObject = $controler->loadResult($startObject->id);
            $reviewObject->typeResult = "review";
            echo json_encode($reviewObject);
            return;
        }else if($startObject->status == "start"){
            $playObject = $controler->loadForPlay($startObject->id);
            $playObject->typeResult = "play";
            echo json_encode($playObject);
            return;
        }
        break;

    case "loadResult":
        echo json_encode($controler->loadResult());
        break;

}


