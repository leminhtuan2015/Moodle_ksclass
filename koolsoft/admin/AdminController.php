<?php
/**
 * Created by PhpStorm.
 * User: xuan
 * Date: 27/12/2016
 * Time: 14:07
 */
require_once(__DIR__."/../application/ApplicationController.php");
require_once('../../config.php');
require_once(__DIR__.'/../../lib/adminlib.php');
require_once(__DIR__.'/../../lib/authlib.php');
require_once(__DIR__.'/../../user/filters/lib.php');
require_once(__DIR__.'/../../user/lib.php');
//require_once($CFG->libdir.'/adminlib.php');
//require_once($CFG->libdir.'/authlib.php');
//require_once($CFG->dirroot.'/user/filters/lib.php');
//require_once($CFG->dirroot.'/user/lib.php');
class AdminController extends  ApplicationController {


    function __construct() {
        parent::__construct();
    }

    public function index() {
        require_once(__DIR__.'/views/index.php');
    }

    public function show_list_user(){
        $xxx = "fuck";
        require_once(__DIR__.'/views/list_user.php');
    }

}