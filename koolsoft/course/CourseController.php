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
require_once (__DIR__."/../category/CategoryController.php");

class CourseController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index($categoryid) {
        global $USER;

        $courses = get_courses($categoryid);

//        error_log(print_r($USER->sesskey, true));
//        $SESSION->sesskey = $USER->sesskey;

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

    public function newCourse($id){
        if($id){
            $course = get_course($id);
        }

        $categoryController = new CategoryController();
        $categories = $categoryController->getAllCategories();
        $categoriesName = $categoryController->getPathCategory($categories);

        require_once(__DIR__.'/views/new.php');
    }

    public function create(){
        global $DB;

        $data = new stdClass();
        $data->fullname = $_POST["name"];
        $data->shortname = $_POST["name"];
        $data->category = $_POST["categoryId"];
        $data->visible = $_POST["visible"];
//        $data->numsections = 0;
        $lectures = $_POST["lectures"];
//        error_log(print_r($lectures, true));
        $course = create_course($data);

        if($course){
//            $DB->delete_records('course_sections', array('course' => $course->id, 'section' => 0));
            $numberSections = 0;

            foreach ($lectures as $index => $lecture) {
                if ($lecture[name]) {
//                    error_log(print_r($lecture[name], true));
//                    error_log(print_r($course->id, true));
                    $section = new stdClass();
                    $section->name = $lecture[name];
                    $section->course = $course->id;
                    $section->section  = $index + 1;
                    $section->summary  = '';
                    $section->summaryformat = FORMAT_HTML;
                    $section->sequence = '';
                    $id = $DB->insert_record("course_sections", $section);
                    $numberSections ++;
//                    error_log(print_r("section: ".$id, true));
                }
            }

            update_course((object)array('id' => $course->id, 'numsections' => $numberSections));

            redirect("/moodle/koolsoft/course/?action=show&id=$course->id");
        }
    }

    public function myCourse(){
        global $USER;
        $courses = enrol_get_all_users_courses($USER->id, true, null, 'visible DESC, sortorder ASC');

        require_once(__DIR__.'/views/myCourse.php');
    }

    public function edit($id){
        global $USER;

        if($id){
            $course = get_course($id);
            $modinfo = get_fast_modinfo($course);
            $sections = $modinfo->get_section_info_all();
            $categoryController = new CategoryController();
            $categories = $categoryController->getAllCategories();
            $categoriesName = $categoryController->getPathCategory($categories);
//            error_log(print_r($sections, true));
        }

        require_once(__DIR__.'/views/edit.php');
    }

    public function update(){
        global $DB;

        error_log(print_r($_POST, true));

        $data = new stdClass();
        $data->id = $_POST["id"];
        $data->fullname = $_POST["name"];
        $data->shortname = $_POST["name"];
        $data->category = $_POST["categoryId"];
        $data->visible = $_POST["visible"];
        update_course($data);

        $lectures = $_POST["lectures"];

        $newNumberSections = 0;

        foreach ($lectures as $index => $lecture) {
            if ($lecture[name] && $lecture[sectionId]) {
                // UPDATE SECTIONS
//              error_log(print_r($lecture[name], true));
//              error_log(print_r($course->id, true));
                $section = new stdClass();
                $section->id = $lecture[sectionId];
                $section->name = $lecture[name];
                $id = $DB->update_record("course_sections", $section);
//              error_log(print_r("section: ".$id, true));
            } else if($lecture[name]) {
                // CREATE NEW SECTIONS
                $section = new stdClass();
                $section->name = $lecture[name];
                $section->course = $data->id;
                $section->section  = $index;
                $section->summary  = '';
                $section->summaryformat = FORMAT_HTML;
                $section->sequence = '';
                $id = $DB->insert_record("course_sections", $section);
                $newNumberSections ++;
            }
        }

        if($newNumberSections) {
            $course = get_course($_POST["id"]);
            $courseformatoptions = course_get_format($course)->get_format_options();

            $courseformatoptions['numsections'] += $newNumberSections;
            update_course((object)array('id' => $course->id, 'numsections' => $courseformatoptions['numsections']));
        }

        redirect("/moodle/koolsoft/course/?action=show&id=$data->id");
    }

    public function delete($id){
        delete_course($id, false);

        redirect("/moodle/koolsoft/course");
    }

    public function deleteSection($id){
        global $DB;

        $section = $DB->get_record('course_sections', array('id' => $id), '*', MUST_EXIST);
        $course = $DB->get_record('course', array('id' => $section->course), '*', MUST_EXIST);
        $sectionnum = $section->section;
        $sectioninfo = get_fast_modinfo($course)->get_section_info($sectionnum);

        if (course_can_delete_section($course, $sectioninfo)) {
            course_delete_section($course, $sectioninfo, true, true);
        }

        redirect("/moodle/koolsoft/course?action=edit&id=$course->id");
    }

    //    PRIVATE ----------------------------------------------- PRIVATE
    private function enrolledUsers($courseId){
        $context = context_COURSE::instance($courseId);
        $enrolledUsers = get_enrolled_users($context, 'mod/assignment:submit');
        return $enrolledUsers;
    }
}