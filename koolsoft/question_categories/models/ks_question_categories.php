<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/27/16
 * Time: 9:25 AM
 */
global $CFG;
require_once($CFG->dirroot."/config.php");
require_once($CFG->dirroot."/lib/moodlelib.php");
require_once($CFG->dirroot."/koolsoft/question/models/ks_question.php");
class ks_question_categories
{
    function __construct() {

    }

    public function createCategory($userId, $name, $info, $parentId, $type){
        global $DB;
        $category = new stdClass();
        $category->parent = $parentId;
        $category->contextid = 0;
        if($name){
            $category->name = $name;
        }else {
            $category->resultText = "Name is empty!";
            return $category;
        }
        $category->info = $info;
        $category->infoformat = 1;
        $category->sortorder = 999;
        $category->stamp = make_unique_id_code();
        $category->userid = $userId;
        $category->type = $type;
        $category->id = $DB->insert_record("question_categories", $category);
        $category->result_text = "Success";

        return $category;
    }

    public function updateCategory($id, $userId, $name, $info, $categoryId, $type){
        global $DB;
        $params = array("id" => $id);
        $category = $DB->get_record('question_categories', $params);
        if($category){
            if($categoryId){
                $category->parent = $categoryId;
            }
            if($name){
                $category->name = $name;
            }else {
                $params = array("id" => $id);
                $category = $DB->get_record('question_categories', $params);
                $category->resultText = "Name is empty!";
                return $category;
            }
            if($info){
                $category->info = $info;
            }
            if($userId){
                $category->userid = $userId;
            }
            if($type){
                $category->type = $type;
            }

            $DB->update_record("question_categories", $category);

            $category->result_text = "Success";
            return $category;
        }else {
            return null;
        }
    }

    public function loadCategoryByUser($idUser){
        global $DB;
        $sql = 'SELECT * FROM '.$DB->get_prefix().'question_categories WHERE userid ='.$idUser;
        $categories = $DB->get_records_sql($sql, array());
        return $categories;
    }

    public function loadCategory($id){
        global $DB;
        $params = array("id" => $id);
        $category = $DB->get_record('question_categories', $params);
        return $category;
    }

    public function loadCategoryByParent($idParent){
        global $DB;
        $sql = 'SELECT * FROM '.$DB->get_prefix().'question_categories WHERE parent ='.$idParent;
        $categories = $DB->get_records_sql($sql, array());
        return $categories;
    }

    public function loadCategoryByTypeAndUser($type, $userId){
        global $DB;
        $sql = 'SELECT * FROM '.$DB->get_prefix().'question_categories WHERE userid ='.$userId.' AND type ='.$type;
        $categories = $DB->get_records_sql($sql, array());
        return $categories;
    }

    public function deleteCategory($id){
        global $DB;
        $params = array("id" => $id);
        $category = $DB->get_record('question_categories', $params);
        if($category){
            if($category->type == 1){
                $questionstomove = $DB->count_records("question", array("category" => $id));
                $categoryChild = $DB->count_records("question_categories", array("parent" => $id));
                if($questionstomove == 0 && $categoryChild == 0){
                    $DB->delete_records("question_categories", array("id" => $id));
                    return true;
                }else {
                    return false;
                }
            }else if($category->type == 2){
                $DB->delete_records("question_categories", array("id" => $id));
                $questionDeletes = $DB->count_records("question", array("category" => $id));
                foreach($questionDeletes as $question){
                    $daoQuestion = new ks_question();
                    $daoQuestion->delete_question($question->id);
                }
                return true;
            }
        }
    }
}