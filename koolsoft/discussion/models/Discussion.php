<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 1/14/17
 * Time: 2:12 PM
 */

require_once(__DIR__."/../../../mod/forum/lib.php");

class Discussion {

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

    public static function createReply($replyId, $replyMessage){
        global $DB, $USER;

        $parent = forum_get_post_full($replyId);

        $reply = new stdClass();
        $reply->discussion  = $parent->discussion;
        $reply->parent  = $parent->id;
        $reply->userid  = $USER->id;
        $reply->created  = DateUtil::getTimestampNowDiscussion();
        $reply->modified  = DateUtil::getTimestampNowDiscussion();
        $reply->mailed  = 0;
        $reply->subject = "_";
        $reply->message = $replyMessage;
        $reply->messageformat = 1;
        $reply->messagetrust = 0;
        $reply->attachment = 0;
        $reply->totalscore = 0;
        $reply->mailnow = 0;


        $id = $DB->insert_record('forum_posts', $reply);

//        error_log(print_r($id, true));

        if($id){
            $post_child = new stdClass();
            $post_child->firstname = $USER->firstname;
            $post_child->message = $replyMessage;
            $post_child->post_time_human = DateUtil::getHumanDateDiscussion($reply->created);

            error_log(print_r($post_child, true));

            return $post_child;
        } else {
            return false;
        }
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

            $posts = forum_get_all_discussion_posts($discussion->id, "p.created DESC")[$parent]->children;

            foreach ($posts as $post) {
                $post->post_time_human = DateUtil::getHumanDateDiscussion($post->created);
            }

            $discussion->children = $posts;
//            $firstpost = forum_get_firstpost_from_discussion($discussion->id);
//            Logger::log($discussion);
        }

        return array("forumId" => $forumId, "discussions" => $discussions);
    }

}