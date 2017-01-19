<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/27/16
 * Time: 10:25 PM
 */

global $CFG, $USER;

require_once($CFG->libdir.'/filelib.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/repository/lib.php');

class File {

    public static function all(){
        global $DB, $USER;

        $files = $DB->get_records("files", array('userid'=>$USER->id));

        return $files;
    }

    public static function filesOfCourse($course_id){
        global $DB, $USER;

        $files = $DB->get_records("files", array('userid'=>$USER->id, "course_id"=>$course_id));

        return $files;
    }

    public static function get($id){
        global $DB, $USER;

        $file = $DB->get_record("files", array('id'=>$id));

        return $file;
    }

    public static function upload($fileInfo){
        global $DB;

        Logger::log($fileInfo);

        $course_id = optional_param("course_id", 0, PARAM_INT);

        $fileTmp = $fileInfo['tmp_name'];
        $fileName = $fileInfo['name'];
        $status = move_uploaded_file($fileTmp, $fileTmp);

        if($status){
            $file = File::buildFileObject($fileName, $fileTmp, $course_id);
            $id = $DB->insert_record('files', $file);

            if($id){
                $file->id = $id;
                return $file;
            }
        }

        return "";
    }

    private static function buildFileObject($filename, $filepath, $course_id = 0){
        global $USER;

        $file = new stdClass();

        $milliseconds = round(microtime(true) * 1000);

        error_log(print_r($milliseconds, true));

        $file->filename = $filename;
        $file->userid = $USER->id;
        $file->course_id = $course_id;
        $file->filepath = $filepath;
        $file->status = 0;
        $file->timecreated = 0;
        $file->timemodified = 0;
        $file->filesize = 0;

        $file->contenthash = "$milliseconds.$USER->id";
        $file->pathnamehash = "$milliseconds.$USER->id";

        $file->contextid = 0;
        $file->component = "0";
        $file->filearea = "0";
        $file->itemid = 0;
        $file->mimetype = "0";
        $file->source = "0";
        $file->author = "0";
        $file->license = "0";
        $file->sortorder = 0;
        $file->referencefileid = 0;

        return $file;
    }


}