<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/27/16
 * Time: 1:25 PM
 */

global $CFG, $USER;

require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../application/ApplicationController.php");
require_once(__DIR__."/models/FileUtil.php");
require_once($CFG->dirroot.'/repository/upload/lib.php');

class FileController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index(){
        require_login();

        require_once("views/index.php");
    }

    public function upload(){
    }

}