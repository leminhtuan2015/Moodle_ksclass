<?php

require_once(__DIR__."/../../../config.php");
require_once(__DIR__."/../../../course/lib.php");
require_once(__DIR__.'/../../../lib/filelib.php');
require_once(__DIR__.'/../../../lib/gradelib.php');
require_once(__DIR__.'/../../../lib/completionlib.php');
require_once(__DIR__.'/../../../lib/plagiarismlib.php');
require_once(__DIR__.'/../../../course/modlib.php');



class Label extends  stdClass {


    public $visible =0;
    public $tags = "";
    public $course = 0;
    public $coursemodule = 0;
    public $section =0;
    public $module = 0;
    public $modulename = "label";
    public $instance = 0;
    public $add = "label";
    public $update = 0;
    public $return = 0;
    public $sr = 0;
    public $competency_rule = 0;
    public $submitbutton2 = "Save and return to course";
    public $arrayEditor = array();
    public $introeditor;

    function __construct(){
        $this->arrayEditor['format'] = 1;
        $this->arrayEditor['itemid'] = 235401165;
        $this->introeditor = $this->arrayEditor;
    }


    // truong add data
    public function addData($id,$section,$label){
        global $DB;
        $data = $this->getLabelObject($id,$section,$label);
        $course = $DB->get_record('course', array('id'=>$id), '*', MUST_EXIST);
        error_log(print_r($data, true));
        add_moduleinfo($data, $course, null);
    }

    public function getLabelObject($id,$section,$label){
        $arrayEditor = array();
        $arrayEditor['text'] = $label;
        $arrayEditor['format'] = 1;
        $arrayEditor['itemid'] = 235401165;
        $data = new stdClass();
        $data->introeditor = $arrayEditor;
        $data->visible = 1;
        $data->tags = "";
        $data->course = $id;
        $data->coursemodule = 0;
        $data->section = $section;
        $data->module = 12;
        $data->modulename = "label";
        $data->instance = 0;
        $data->add = "label";
        $data->update = 0;
        $data->return = 0;
        $data->sr = 0;
        $data->competency_rule = 0;
        $data->submitbutton2 = "Save and return to course";
        return $data;
    }






}
