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
        parent::__construct();
    }

    public function index(){
        require_login();

        $files = File::all();

//        Logger::log($files);

        require_once("views/index.php");
    }

    public function upload(){
        $idFile = File::upload($_FILES['file']);

        if($idFile){
            redirect("/moodle/koolsoft/file");
        }
    }

    public function download(){
        $idFile = optional_param('id', "", PARAM_INT);

        $file = File::get($idFile);

        if (file_exists($file->filepath)) {
            Logger::log($file->filepath);
            Logger::log(filesize($file->filepath));

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="phpHrvFkb"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file->filepath));
            readfile($file->filepath);
            exit;
        } else {
            Logger::log("The file does not exist");
            echo 'The file does not exist.';
        }
    }
}