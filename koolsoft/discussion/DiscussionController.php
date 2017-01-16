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
require_once($CFG->dirroot."/koolsoft/course/models/Course.php");

class DiscussionController extends ApplicationController {

    function __construct() {
    }

    public function index(){
        $courseid = optional_param('courseid', "", PARAM_TEXT);

        $course = Course::getCourse($courseid);
        $modinfo = get_fast_modinfo($course);

        $forumData = Discussion::allDiscussionOfCourse($modinfo);

        $forumId = $forumData["forumId"];
        $discussions = $forumData["discussions"];

        include ("views/index.php");
    }

    public function create(){
        $courseId = $_POST["courseId"];
        $forum = $_POST["forum"];
        $message = $_POST["message"];

        $discussion = Discussion::createDiscussion($forum, $message, $courseId);

        include ("./views/discussion.php");
    }

    public function createReply(){
        $replyId = $_POST["replyId"];
        $replyMessage = $_POST["replyMessage"];

        $post_child = Discussion::createReply($replyId, $replyMessage);

        include ("views/reply.php");
    }
}