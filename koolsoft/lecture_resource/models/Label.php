<?php

require_once(__DIR__."/../../../config.php");
require_once(__DIR__."/../../../course/lib.php");
require_once(__DIR__.'/../../../lib/filelib.php');
require_once(__DIR__.'/../../../lib/gradelib.php');
require_once(__DIR__.'/../../../lib/completionlib.php');
require_once(__DIR__.'/../../../lib/plagiarismlib.php');
require_once(__DIR__.'/../../../course/modlib.php');



class Label extends  stdClass {

    public function get($coursemoduleId){
        global $DB;

        $courseModule = get_coursemodule_from_id('', $coursemoduleId, 0, false, MUST_EXIST);
        $cm = get_coursemodule_from_id('', $coursemoduleId, 0, false, MUST_EXIST);
        $course = $DB->get_record('course', array('id'=>$cm->course), '*', MUST_EXIST);

        list($cm, $context, $module, $data, $cw) = get_moduleinfo_data($cm, $course);

        return $data;
    }

    public function addData($courseId, $section, $labelContent){
        global $DB;

        $data = $this->buildLabelObject($courseId, $section, $labelContent);
        $course = $DB->get_record('course', array('id'=>$courseId), '*', MUST_EXIST);
        $moduleinfo = add_moduleinfo($data, $course);

        return $moduleinfo;
    }

    public function update($courseId, $section, $labelContent, $coursemoduleId){
        global $DB;

        $courseModule = get_coursemodule_from_id('', $coursemoduleId, 0, false, MUST_EXIST);
        $cm = get_coursemodule_from_id('', $coursemoduleId, 0, false, MUST_EXIST);
        $course = $DB->get_record('course', array('id'=>$cm->course), '*', MUST_EXIST);
        $data = $this->buildLabelObject($courseId, $section, $labelContent, $coursemoduleId);

        update_moduleinfo($cm, $data, $course);
    }

    private function buildLabelObject($courseId, $section, $labelContent, $coursemodule=0){
        $arrayEditor = array();
        $arrayEditor['text'] = $labelContent;
        $arrayEditor['format'] = 1;
        $arrayEditor['itemid'] = 235401165;

        $data = new stdClass();
        $data->introeditor = $arrayEditor;
        $data->visible = 1;
        $data->tags = "";
        $data->course = $courseId;
        $data->coursemodule = $coursemodule;
        $data->section = $section;
        $data->module = 12;
        $data->modulename = "label";
        $data->instance = 0;
        $data->add = "label";
        $data->update = $coursemodule;
        $data->return = 0;
        $data->sr = 0;
        $data->competency_rule = 0;
        $data->submitbutton2 = "Save and return to course";

        return $data;
    }
}
