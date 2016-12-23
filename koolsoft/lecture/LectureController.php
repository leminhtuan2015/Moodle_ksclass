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


        require_once(__DIR__.'/views/show.php');
    }

}