<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/3/17
 * Time: 7:42 PM
 */
global $CFG;
require_once($CFG->dirroot."/config.php");
class ks_question_tag
{

    function __construct() {

    }

    public function create( $name){
        global $DB;
        $tag = new stdClass();
        if($name){
            $tag->name = $name;
        }else {
            $tag->resultText = "Name is empty!";
            return $tag;
        }

        $tag->id = $DB->insert_record("tag_new", $tag);
        $tag->resultText = "Success";

        return $tag;
    }

    public function update($id, $name){
        global $DB;
        $params = array("id" => $id);
        $tag = $DB->get_record('tag_new', $params);
        if($tag){
            if($name){
                $tag->name = $name;
            }else {
                $tag->resultText = "Name is empty!";
                return $tag;
            }
            $DB->update_record("tag_new", $tag);

            $tag->resultText = "Success";
            return $tag;
        }else {
            return null;
        }
    }

    public function loadAll(){
        global $DB;
        $tags = $DB->get_records("tag_new");
        return $tags;
    }

    public function loadOne($id){
        global $DB;
        $params = array("id" => $id);
        $tag = $DB->get_record('tag_new', $params);
        return $tag;
    }

    public function delete($id){
        global $DB;
        $params = array("id" => $id);
        $tag = $DB->get_record('tag_new', $params);
        if($tag){
            $DB->delete_records("tag_new", array("id" => $id));
            return true;
        }else{
            return false;
        }
    }
}