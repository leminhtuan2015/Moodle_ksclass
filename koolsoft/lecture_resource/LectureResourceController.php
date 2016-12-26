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
        global $DB;

        $courseId = optional_param('courseId', 0, PARAM_INT);
        $section = optional_param('section', 0, PARAM_INT);
        $sectionId = optional_param('sectionId', 0, PARAM_INT);

        require_once(__DIR__."/views/new.php");
    }

    function edit(){
        $courseId = optional_param('courseId', 0, PARAM_INT);
        $section = optional_param('section', 0, PARAM_INT);
        $sectionId = optional_param('sectionId', 0, PARAM_INT);
        $moduleId = optional_param('moduleId', 0, PARAM_INT);

        $label = new Label();
        $lableData = $label->get($moduleId);
        $labelContent = "$lableData->intro";

        require_once(__DIR__."/views/edit.php");
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

    function update(){
        $labelContent = $_POST['labelContent'];
        $courseId = $_POST['courseId'];
        $section = $_POST['section'];
        $sectionId = $_POST['sectionId'];
        $moduleId = $_POST['moduleId'];

        Logger::log("Update: $labelContent : $courseId : $section: $sectionId : $moduleId");

        $label = new Label();
        $label->update($courseId, $section, $labelContent, $moduleId);
    }
}