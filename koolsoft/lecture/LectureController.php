<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/22/16
 * Time: 1:47 PM
 */

require_once(__DIR__."/../application/ApplicationController.php");
require_once("../../config.php");
require_once($CFG->dirroot. '/course/lib.php');
require_once($CFG->libdir. '/coursecatlib.php');
require_once(__DIR__."/models/Label.php");

class LectureController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function show($id, $courseId) {
        global $DB;

        $params = array('id' => $courseId);
        $course = $DB->get_record('course', $params, '*', MUST_EXIST);

        $modinfo = get_fast_modinfo($course);
        $modnames = get_module_types_names();
        $modnamesplural = get_module_types_names(true);
        $modnamesused = $modinfo->get_used_module_names();
        $mods = $modinfo->get_cms();
        $sections = $modinfo->get_section_info_all();

//      $sections : All section of a course
//      Logger::log($sections);

//      sections[i] -> [section_info(id, name, section)] -> modinfo -> (course, userid, sections[], cms[cm_info], instances[forum, lable[cm_info]])
//      NOTICE: cms[cm_info], array cms[] contain list of cm_info, cm_info contain all infomation about Section + Module of this section
//      cm_info->id = the id of this module
//      cm_info->section = the id of section
//      cm_info->modname = name of module in this section
//      cm_info->content  = the content of module (content of lable)

        require_once(__DIR__.'/views/show.php');
    }

    function newResouce() {
        global $DB;

        $courseId = optional_param('courseId', 0, PARAM_INT);
        $section = optional_param('section', 0, PARAM_INT);
        $sectionId = optional_param('sectionId', 0, PARAM_INT);

        require_once(__DIR__."/views/new.php");
    }

    function edit(){
        global $DB;

        $courseId = optional_param('courseId', 0, PARAM_INT);
        $section = optional_param('section', 0, PARAM_INT);
        $sectionId = optional_param('sectionId', 0, PARAM_INT);
        $moduleId = optional_param('moduleId', 0, PARAM_INT);

        $course = get_course($courseId);
        $modinfo = get_fast_modinfo($course);
        $sections = $modinfo->get_section_info_all();

        $courseSection = null;

        foreach ($sections as $s) {
            if($courseSection){
                break;
            }

            if($s->id == $sectionId){
                $courseSection = $s;
            }
        }

//        Logger::log($courseSection);

        $label = new Label();
        $lableData = $label->get($moduleId);
        $labelContent = "$lableData->intro";

        $labelContent = str_replace(array("\r", "\n"), '', $labelContent);

        require_once(__DIR__."/views/edit.php");
    }

    function create(){
        global $DB;

        $courseId = $_POST['courseId'];
        $labelContent = $_POST['labelContent'];
        $name = $_POST["name"];
        $description = $_POST["description"];

        $course = $DB->get_record('course', array('id' => $courseId), '*', MUST_EXIST);
        $courseformatoptions = course_get_format($course)->get_format_options();

//        Logger::log($course->fullname);
//        Logger::log($courseformatoptions);

        $section = new stdClass();
        $section->name = $name;
        $section->course = $courseId;
        $section->section  = $courseformatoptions['numsections'] + 1;
        $section->summary  = $description;
        $section->summaryformat = FORMAT_HTML;
        $section->sequence = '';
        $id = $DB->insert_record("course_sections", $section);

        $courseformatoptions['numsections']++;
        update_course((object)array('id' => $courseId, 'numsections' => $courseformatoptions['numsections']));

        $label = new Label();
        $moduleinfo = $label->addData($courseId, $section->section, $labelContent);

        redirect("/moodle/koolsoft/course/?action=show&id=$courseId");
    }

    function update(){
        global $DB;

        $labelContent = $_POST['labelContent'];
        $courseId = $_POST['courseId'];
        $section = $_POST['section'];
        $sectionId = $_POST['sectionId'];
        $moduleId = $_POST['moduleId'];
        $name = $_POST["name"];
        $summary = $_POST["summary"];
        $description = $_POST["description"];

        // UPDATE SECTIONS
        $courseSection = new stdClass();
        $courseSection->id = $sectionId;
        $courseSection->name = $name;
        $courseSection->summary = $summary;
        $id = $DB->update_record("course_sections", $courseSection);

        $label = new Label();
        $label->update($courseId, $section, $labelContent, $moduleId);

        redirect("/moodle/koolsoft/lecture/?action=show&id=$sectionId&courseId=$courseId");
    }

    public function delete($id){
        global $DB;

        $section = $DB->get_record('course_sections', array('id' => $id), '*', MUST_EXIST);
        $course = $DB->get_record('course', array('id' => $section->course), '*', MUST_EXIST);
        $sectionnum = $section->section;
        $sectioninfo = get_fast_modinfo($course)->get_section_info($sectionnum);

        if (course_can_delete_section($course, $sectioninfo)) {
            course_delete_section($course, $sectioninfo, true, true);
        }

        redirect("/moodle/koolsoft/course/?action=show&id=$course->id");
    }

}