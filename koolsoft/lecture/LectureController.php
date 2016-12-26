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

}