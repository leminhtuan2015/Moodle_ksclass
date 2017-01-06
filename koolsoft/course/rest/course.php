<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/7/17
 * Time: 12:18 AM
 */

require_once("../../../config.php");
require_once("../../course/models/CourseUtil.php");

global $DB;
$action  = optional_param('action', 0, PARAM_TEXT);

switch ($action) {
    case "listSectionChild":

            $idParent  = optional_param('idParent', 0, PARAM_INT);
            echo json_encode(CourseUtil::getSectionChild($idParent));
        break;
}