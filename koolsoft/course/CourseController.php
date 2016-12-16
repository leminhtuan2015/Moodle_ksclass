<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 9:41 PM
 */
require_once("../../config.php");
require_once($CFG->dirroot. '/course/lib.php');
require_once($CFG->libdir. '/coursecatlib.php');
require_once(__DIR__."/../application/ApplicationController.php");

class CourseController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index($categoryid) {
        $courses = get_courses($categoryid);

        require_once(__DIR__.'/views/index.php');
    }
    public function show($id) {
        global $DB;

        $params = array('id' => $id);
        $course = $DB->get_record('course', $params, '*', MUST_EXIST);

        $modinfo = get_fast_modinfo($course);
        $modnames = get_module_types_names();
        $modnamesplural = get_module_types_names(true);
        $modnamesused = $modinfo->get_used_module_names();
        $mods = $modinfo->get_cms();
        $sections = $modinfo->get_section_info_all();

        $context = context_COURSE::instance($course->id);
        $enrolledUsers = get_enrolled_users($context, 'mod/assignment:submit');
        $enrolledUsers = $this->enrolledUsers($course->id);

        require_once(__DIR__.'/views/show.php');
    }

    public function edit($id){
        if($id){
            $course = get_course($id);
        }

        require_once(__DIR__.'/views/edit.php');
    }

    private function enrolledUsers($courseId){
        $context = context_COURSE::instance($courseId);
        $enrolledUsers = get_enrolled_users($context, 'mod/assignment:submit');
        return $enrolledUsers;
    }
}