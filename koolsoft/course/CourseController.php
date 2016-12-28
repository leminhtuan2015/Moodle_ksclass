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
require_once (__DIR__."/models/CourseUtil.php");

class CourseController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index($categoryid) {
        global $USER;

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

//        Logger::log($sections);

        $context = context_COURSE::instance($course->id);
        $enrolledUsers = get_enrolled_users($context, 'mod/assignment:submit');
        $enrolledUsers = CourseUtil::enrolledUsers($course->id);

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
        $data->numsections = 0;
        $course = create_course($data);

        if($course){
            $this->setSelfEnrolment($course->id, $_POST["payment"]);
        }

        redirect("/moodle/koolsoft/course/?action=show&id=$course->id");
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
            $isFree = CourseUtil::isFree($id);
        }

        require_once(__DIR__.'/views/edit.php');
    }

    public function update(){
        global $DB;

        $data = new stdClass();
        $data->id = $_POST["id"];
        $data->fullname = $_POST["name"];
        $data->shortname = $_POST["name"];
        $data->category = $_POST["categoryId"];
        $data->visible = $_POST["visible"];
        update_course($data);

        $this->setSelfEnrolment($data->id, $_POST["payment"]);

        redirect("/moodle/koolsoft/course/?action=show&id=$data->id");
    }

    public function delete($id){
        delete_course($id, false);

        redirect("/moodle/koolsoft/course");
    }

    public function selfEnrol(){
        global $USER;

        $id = $_GET['id'];

        CourseUtil::selfEnrol($id, $USER->id);

        redirect("/moodle/koolsoft/course");
    }

    public function unEnrol(){
        global $USER;

        $id = $_GET['id'];

        CourseUtil::unEnrol($id, $USER->id);

        redirect("/moodle/koolsoft/course");
    }

    private function setSelfEnrolment($courseId, $payment){
        $isFree = false;

        if($payment == "0"){
            $isFree = true;
        } else {
            $isFree = false;
        }

        Logger::log($courseId);
        Logger::log($payment);

        CourseUtil::enableSelfEnrol($courseId, $isFree);
    }
}