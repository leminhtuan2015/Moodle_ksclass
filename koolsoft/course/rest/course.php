<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/7/17
 * Time: 12:18 AM
 */
header('Access-Control-Allow-Origin: *');

require_once("../../../config.php");
require_once("../../course/models/Course.php");

global $DB;
$action  = optional_param('action', 0, PARAM_TEXT);

switch ($action) {
    case "listSectionChild":
        $idParent  = optional_param('idParent', 0, PARAM_INT);
        echo json_encode(Course::getSectionChild($idParent));
        break;
    case "listSectionEqualParent":
        $idSection  = optional_param('idSection', 0, PARAM_INT);
        echo json_encode(Course::getSectionEqualParent($idSection));
        break;
    case "courses":
        header('Access-Control-Allow-Origin: *');
        $courses = Course::getCourses();
        echo json_encode($courses);
        break;
    case "get":
        $id  = optional_param('id', 0, PARAM_INT);
        $courseData = Course::getCourseDataAll($id);

        error_log(print_r($courseData, true));

        echo json_encode($courseData, JSON_FORCE_OBJECT);
        break;
    case "getLectureOfChapter":
        $courseId  = optional_param('courseId', 0, PARAM_INT);
        $chapterId  = optional_param('chapterId', 0, PARAM_INT);

        error_log(print_r($courseId, true));
        error_log(print_r($chapterId, true));

        list ($chapters, $sections) = Course::getCourseDataAll($courseId);

        error_log(print_r($sections, true));
        error_log(print_r($chapters, true));

        $sectionOfChapter = array();

        foreach ($sections as $section) {
            if($section->parent_id == $chapterId){

                $sec = new stdClass();
                $sec->id = $section->id;
                $sec->name = $section->name;

                array_push($sectionOfChapter, $sec);
            }
        }

        echo json_encode($sectionOfChapter, JSON_FORCE_OBJECT);
        break;
    case "getChapterOfCourse":
        $id  = optional_param('id', 0, PARAM_INT);

        list ($chapters, $sections) = Course::getCourseDataAll($id);

        error_log(print_r($chapters, true));

        echo json_encode($chapters, JSON_FORCE_OBJECT);
        break;
}
?>

