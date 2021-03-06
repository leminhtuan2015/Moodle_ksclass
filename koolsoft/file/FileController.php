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
require_once(__DIR__."/models/File.php");
require_once($CFG->dirroot.'/repository/upload/lib.php');

class FileController extends ApplicationController {

    function __construct() {
    }

    public function index(){
        require_login();

        $files = File::all();

//        Logger::log($files);

        require_once("views/index.php");
    }

    public function filesOfCourse(){
        require_login();

        global $CFG;

        $coure_id = optional_param("course_id", 0, PARAM_INT);

        Logger::log($coure_id);

        $files = File::filesOfCourse($coure_id);

        require_once("views/index.php");
    }

    public function upload(){
        $file = File::upload($_FILES['file']);

//        Logger::log($_FILES['file']);

        if($file){
            include ("views/file_item.php");
        }
    }

    public function download(){
        $idFile = optional_param('id', "", PARAM_INT);

        $file = File::get($idFile);

//        Logger::log($_SERVER);

        header('Content-Disposition: attachment; filename="'. $file->filename .'"');
        header('Content-Type: "application/download"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($file->filepath));

        if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
            header('Pragma: public');
        } else {
            header('Pragma: no-cache');
        }

        readfile($file->filepath);
    }
}