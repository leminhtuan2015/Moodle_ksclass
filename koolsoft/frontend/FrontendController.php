<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/28/16
 * Time: 10:24 AM
 */

require_once(__DIR__."/../application/ApplicationController.php");
require_once(__DIR__."/../course/models/CourseUtil.php");

class FrontendController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index(){
        $courses = CourseUtil::getCourses();
        $myCourses = CourseUtil::getMyCourses();

        require_once("views/index.php");
    }
}