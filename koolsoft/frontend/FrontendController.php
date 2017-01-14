<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/28/16
 * Time: 10:24 AM
 */

require_once(__DIR__."/../application/ApplicationController.php");
require_once(__DIR__."/../course/models/Course.php");

class FrontendController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index(){
        global $USER;

        $courses = Course::getCourses();
        $myFollowingCourses = Course::getMyCourses();
        $myCreatedCourses = Course::getCoursesByCreator($USER->id);

//        require_once("views/index.php");
        require_once("views/v1/index.php");
    }
}