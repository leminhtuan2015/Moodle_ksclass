<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 9:41 PM
 */
require_once(__DIR__."/../../config.php");

require_once(__DIR__."/../application/ApplicationController.php");
require_once (__DIR__."/../category/CategoryController.php");
require_once (__DIR__."/models/CourseUtil.php");

class CourseController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index($categoryid) {
        $courses = CourseUtil::getCourses($categoryid);

        require_once(__DIR__.'/views/index.php');
    }

    public function show($id) {
        global $DB;

        $lectureActive = optional_param('lectureActive', "", PARAM_TEXT);
        $tabActive = optional_param('tabActive', "", PARAM_TEXT);

        $course = CourseUtil::getCourse($id);

        $modinfo = get_fast_modinfo($course);
        $modnames = get_module_types_names();
        $modnamesplural = get_module_types_names(true);
        $modnamesused = $modinfo->get_used_module_names();
        $mods = $modinfo->get_cms();
        $sections = $modinfo->get_section_info_all();

        $chapters = $DB->get_records('course_sections', array('course'=>$id, "parent_id"=> 0));

        foreach ($sections as $section){
//            Logger::log($section->id);

            $courseSection = $DB->get_record('course_sections', array('id'=>$section->id));
            $section->parent_id = $courseSection->parent_id;
        }

        $enrolledUsers = CourseUtil::enrolledUsers($id);
        $forumData = CourseUtil::getDefaultForum($modinfo);

        $forumId = $forumData["forumId"];
        $discussions = $forumData["discussions"];

//        require_once(__DIR__.'/views/show.php');
        require_once(__DIR__.'/views/v1/show.php');
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
        global $DB, $USER;

        $humanStartDate = $_POST["startDate"];
        $humanEndDate = $_POST["endDate"];

        $data = new stdClass();

        $data->fullname = $_POST["name"];
        $data->shortname = $_POST["name"];
        $data->category = $_POST["categoryId"];
        $data->visible = $_POST["visible"];
        $data->summary = $_POST["description"];
        $data->sequence  = $_POST["sequence"];
        $data->cost  = $_POST["cost"];
        $data->free_type  = $_POST["free_type"];
        $data->numsections = 0;
        $data->creator_id = $USER->id;

        $data->startdate = DateUtil::getTimestamp($humanStartDate);
        $data->enddate = DateUtil::getTimestamp($humanEndDate);

        $course = create_course($data);

        if($course){
            $this->setSelfEnrolment($course->id, $data->cost);
        }

        redirect("/moodle/koolsoft/course/?action=show&id=$course->id");
    }

    public function myCourse(){
        global $USER;
        $courses = CourseUtil::getMyCourses();

        require_once(__DIR__.'/views/my_course.php');
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

            $course->startdate = DateUtil::getHumanDate($course->startdate);
            $course->enddate = DateUtil::getHumanDate($course->enddate);
        }

        require_once(__DIR__.'/views/edit.php');
    }

    public function update(){
        global $DB;

        $humanStartDate = $_POST["startDate"];
        $humanEndDate = $_POST["endDate"];

        $data = new stdClass();

        $data->id = $_POST["id"];
        $data->fullname = $_POST["name"];
        $data->shortname = $_POST["name"];
        $data->category = $_POST["categoryId"];
        $data->visible = $_POST["visible"];
        $data->summary = $_POST["description"];
        $data->sequence  = $_POST["sequence"];
        $data->cost  = $_POST["cost"];
        $data->free_type  = $_POST["free_type"];

//        Logger::log($data);

        $data->startdate = DateUtil::getTimestamp($humanStartDate);
        $data->enddate = DateUtil::getTimestamp($humanEndDate);

        update_course($data);

//        $DB->update_record('course', $data);
//        $DB->update_record('course', array('id' => $data->id, 'cost' => "123444555"));

        $this->setSelfEnrolment($data->id, $data->cost);

        redirect("/moodle/koolsoft/course/?action=show&id=$data->id");
    }

    public function delete($id){
        delete_course($id, false);

        redirect("/moodle/koolsoft/");
    }

    public function selfEnrol(){
        global $USER;

        $id = $_GET['id'];

        CourseUtil::selfEnrol($id, $USER->id);

        redirect("/moodle/koolsoft/course/?action=show&id=$id");
    }

    public function unEnrol(){
        global $USER;

        $id = $_GET['id'];
        CourseUtil::unEnrol($id, $USER->id);

        redirect("/moodle/koolsoft/");
    }

    public function createDiscussion(){
        $courseId = $_POST["courseId"];
        $forum = $_POST["forum"];
        $message = $_POST["message"];

        CourseUtil::createDiscussion($forum, $message, $courseId);

        redirect("/moodle/koolsoft/course/?action=show&id=$courseId&tabActive=discussionBox");
    }

    private function setSelfEnrolment($courseId, $cost){

//        Logger::log($courseId);
//        Logger::log($payment);

        $isFree = true;

        if($cost){
            $isFree = false;
        }

        CourseUtil::enableSelfEnrol($courseId, $isFree);
    }
}