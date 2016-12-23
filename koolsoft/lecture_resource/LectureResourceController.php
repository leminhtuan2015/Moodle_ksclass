<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/23/16
 * Time: 2:16 PM
 */

require_once("../../config.php");
require_once(__DIR__."/../application/ApplicationController.php");
require_once(__DIR__."/models/Label.php");

class LectureResourceController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    function newResouce() {
        $courseId = optional_param('courseId', 0, PARAM_INT);
        $section = optional_param('section', 0, PARAM_INT);
        $sectionId = optional_param('sectionId', 0, PARAM_INT);
        $moduleId = 96;

        $courseModule = get_coursemodule_from_id('', $moduleId, 0, false, MUST_EXIST);

        Logger::log($courseModule);

        require_once(__DIR__."/views/new.php");
    }

    function create(){
        $labelContent = $_POST['labelContent'];
        $courseId = $_POST['courseId'];
        $section = $_POST['section'];
        $sectionId = $_POST['sectionId'];

        $label = new Label();
        $moduleinfo = $label->addData($courseId, $section, $labelContent);

        redirect("/moodle/koolsoft/lecture/?action=show&id=$sectionId&courseId=$courseId");
    }
}