<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:14 PM
 */

require_once(__DIR__."/../application/ApplicationController.php");

class HomeController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->myCourse();
    }

    private function myCourse(){
        global $USER;
        $courses = enrol_get_all_users_courses($USER->id, true, null, 'visible DESC, sortorder ASC');

        require_once(__DIR__.'/views/index.php');
    }

}