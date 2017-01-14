<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 1/14/17
 * Time: 2:09 PM
 */

global $CFG;

require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../application/ApplicationController.php");
require_once($CFG->dirroot."/koolsoft/discussion/models/Discussion.php");

class DiscussionController extends ApplicationController {

    public function create(){
        $courseId = $_POST["courseId"];
        $forum = $_POST["forum"];
        $message = $_POST["message"];

        Discussion::createDiscussion($forum, $message, $courseId);

        redirect("/moodle/koolsoft/course/?action=show&id=$courseId&tabActive=discussionBox");
    }

}