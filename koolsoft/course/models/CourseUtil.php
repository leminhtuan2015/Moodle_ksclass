<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/27/16
 * Time: 1:07 AM
 */

require_once(__DIR__."/../../../config.php");

require_once($CFG->dirroot. '/course/lib.php');
require_once($CFG->libdir. '/coursecatlib.php');

class CourseUtil {

    public static function getCourses($categoryid){
        $courses = get_courses($categoryid);

        foreach ($courses as $course) {
            $course->isEnroled = CourseUtil::isEnrolled1($course->id);
            $course->isFree = CourseUtil::isFree($course->id);
            $course->isPresent = CourseUtil::isPresent($course);
        }

        return $courses;
    }

    public static function getCourse($id){
        global $DB;

        $params = array('id' => $id);
        $course = $DB->get_record('course', $params, '*', MUST_EXIST);
        $course->isEnroled = CourseUtil::isEnrolled1($id);
        $course->isFree = CourseUtil::isFree($id);
        $course->isPresent = CourseUtil::isPresent($course);

        return $course;
    }

    public static function getMyCourses(){
        global $USER;

        $courses = enrol_get_all_users_courses($USER->id, true, "startdate, enddate, summary", 'visible DESC, sortorder ASC');

        foreach ($courses as $course) {
            $course->isEnroled = CourseUtil::isEnrolled1($course->id);
            $course->isFree = CourseUtil::isFree($course->id);
            $course->isPresent = CourseUtil::isPresent($course);
        }

        return $courses;
    }

    public static function isPresent($course){
        $todayTimeStamp = DateUtil::todayTimestamp();

        if($course->startdate & $course->enddate){
            $result = ($course->startdate <= $todayTimeStamp) & ($todayTimeStamp <= $course->enddate);

            return $result;

        } else if($course->startdate & !$course->enddate){

            return $todayTimeStamp >= $course->startdate;

        } else if(!$course->startdate & $course->enddate){

            return $todayTimeStamp <= $course->enddate;

        } else if(!$course->startdate & !$course->enddate){

            return true;
        }
    }

    public static function isEnrolled($courseId){
        global $USER;
        $coursecontext = context_course::instance($courseId);
        $enrolled = is_enrolled($coursecontext);

        return $enrolled;
    }

    public static function isEnrolled1($courseId){
        global $USER;

        $context = context_course::instance($courseId, MUST_EXIST);
        $enrolled = is_enrolled($context, $USER, '', true);

        return $enrolled;
    }

    public static function isFree($courseId){
        // GET ALL Enrol instance in ks_enrol table with status = 0 (0 is enable)
        // => If exist an instance with enrol=self => this course is enable self-enrol => free

        $enrolinstances = enrol_get_instances($courseId, true);

        foreach ($enrolinstances as $courseenrolinstance) {
            if ($courseenrolinstance->enrol == "self") {
                return true;
            }
        }
    }

    public static function getSelfEnrolInstance($courseId){
        $enrolinstances = enrol_get_instances($courseId, true);

        foreach ($enrolinstances as $courseenrolinstance) {
            if ($courseenrolinstance->enrol == "self") {
                return $courseenrolinstance;
            }
        }
    }

    public static function myEnrolledCourses(){
        $courses  = enrol_get_my_courses();

        return $courses;
    }


    public static function enrolledUsers($courseId){
        $context = context_COURSE::instance($courseId);
        $enrolledUsers = get_enrolled_users($context, 'mod/assignment:submit');
        return $enrolledUsers;
    }

    public static function enableSelfEnrol($courseId, $enable){
        $enrol = enrol_get_plugin("self");
        $instances = enrol_get_instances($courseId, false);

        foreach ($instances as $instance) {
            if($instance->enrol != "self"){
                continue;
            }

            if($enable){
                $enrol->update_status($instance, ENROL_INSTANCE_ENABLED);
            } else {
                $enrol->update_status($instance, ENROL_INSTANCE_DISABLED);
            }
        }
    }

    public static function selfEnrol($courseId, $userId){
        $enrol = enrol_get_plugin("self");
        $instance = self::getSelfEnrolInstance($courseId);

//        Logger::log($instance);

        $enrol->enrol_user($instance, $userId);
    }

    public static function unEnrol($courseId, $userId){
        $enrolinstances = enrol_get_instances($courseId, true);

        foreach ($enrolinstances as $courseenrolinstance) {
            $plugin = enrol_get_plugin($courseenrolinstance->enrol);
            $plugin->unenrol_user($courseenrolinstance, $userId);

//            Logger::log($courseenrolinstance);
        }
    }

    public static function getSectionChild($idParent){
        global $DB;
        $sqlString = "SELECT * FROM ".$DB->get_prefix()."course_sections WHERE parent_id = ".$idParent;
        $sections = $DB->get_records_sql($sqlString, array());
        return $sections;
    }

}