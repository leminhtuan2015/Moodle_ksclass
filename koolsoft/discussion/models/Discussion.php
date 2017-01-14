<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 1/14/17
 * Time: 2:12 PM
 */

require_once(__DIR__."/../../../mod/forum/lib.php");

class Discussion{

    public static function createDiscussion($forum, $message, $courseId){
        require_once(__DIR__."/../../utility/DateUtil.php");

        $discussion = new stdClass();
        $discussion->forum = $forum;
        $discussion->course = $courseId;
        $discussion->name = $message;
        $discussion->message = $message;
        $discussion->messageformat = 1;
        $discussion->messagetrust = 0;
        $discussion->mailnow = 0;

        forum_add_discussion($discussion);
    }

    public static function createReply($reply){
        global $DB;

        $parent = forum_get_post_full($reply);
        $discussion = $DB->get_record('forum_discussions', array('id' => $parent->discussion));
        forum_add_discussion($discussion);
    }

    public static function getDefaultForum($modinfo){
        global $DB;

        // ($modinfo->instances["forum"])[0] BECAUSE when you create new course => Moodle will automaticlly create one forum
        $info = array_values($modinfo->instances["forum"])[0];
        $forumId = $info->instance;
        $courseModuleId = $info->id;

        $discussions = $DB->get_records('forum_discussions', array('forum'=>$forumId), 'timemodified DESC');

        foreach ($discussions as $discussion) {
            $parent = $discussion->firstpost;
            $post_of_discusstion = forum_get_post_full($parent);
            $discussion->post = $post_of_discusstion;
            $discussion->replycount = forum_count_replies($post_of_discusstion);

            $posts = forum_get_all_discussion_posts($discussion->id, "p.created ASC")[$parent]->children;

            $discussion->children = $posts;
//            $firstpost = forum_get_firstpost_from_discussion($discussion->id);
//            Logger::log($discussion);
        }

        return array("forumId" => $forumId, "discussions" => $discussions);
    }

}