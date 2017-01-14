<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:14 PM
 */

require_once(__DIR__."/../application/ApplicationController.php");
require_once(__DIR__."/../course/models/Course.php");
require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../../koolsoft/utility/DateUtil.php");

require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->libdir.'/coursecatlib.php');

class SearchController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index(){
        require_once(__DIR__.'/views/index.php');
    }

    public function show($keyword){

        $courses = Course::search($keyword);

        require_once(__DIR__.'/views/show.php');
    }

}