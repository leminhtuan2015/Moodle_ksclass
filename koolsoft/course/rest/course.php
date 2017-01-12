<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/7/17
 * Time: 12:18 AM
 */
header('Access-Control-Allow-Origin: *');

require_once("../../../config.php");
require_once("../../course/models/CourseUtil.php");

global $DB;
$action  = optional_param('action', 0, PARAM_TEXT);

switch ($action) {
    case "listSectionChild":
        $idParent  = optional_param('idParent', 0, PARAM_INT);
        echo json_encode(CourseUtil::getSectionChild($idParent));
        break;
    case "listSectionEqualParent":
        $idSection  = optional_param('idSection', 0, PARAM_INT);
        echo json_encode(CourseUtil::getSectionEqualParent($idSection));
        break;
    case "courses":
        header('Access-Control-Allow-Origin: *');
        $courses = CourseUtil::getCourses();
        echo json_encode($courses);
        break;
    case "get":
        $id  = optional_param('id', 0, PARAM_INT);
        $courseData = CourseUtil::getCourseDataAll($id);

        error_log(print_r($courseData, true));

        echo json_encode($courseData, JSON_FORCE_OBJECT);
        break;
}
?>

