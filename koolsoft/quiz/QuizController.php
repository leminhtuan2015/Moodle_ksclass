<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/22/16
 * Time: 8:35 AM
 */
require_once("../../config.php");
require_once(__DIR__.'/../../question/editlib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->libdir . '/formslib.php');
require_once(__DIR__."/../application/ApplicationController.php");
require_once(__DIR__."/../../question/type/questiontypebase.php");

class QuizController extends ApplicationController{

    function __construct() {
        parent::__construct();
    }

    public function index() {
        require_once(__DIR__.'/views/index.php');
    }

    public function edit($course, $section, $id, $isSave) {
        require_once(__DIR__.'/views/edit.php');
    }
}