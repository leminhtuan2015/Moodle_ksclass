<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/3/17
 * Time: 8:23 PM
 */

require_once("../../config.php");
require_once(__DIR__."/../application/ApplicationController.php");
class QuestionTagController extends ApplicationController
{
    function __construct() {
        parent::__construct();
    }

    public function show() {
        require_once(__DIR__.'/views/show.php');
    }
}