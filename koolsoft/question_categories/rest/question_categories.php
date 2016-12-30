<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/27/16
 * Time: 12:00 PM
 */

require_once("../../../config.php");
require_once("../../question_categories/models/ks_question_categories.php");
require_once($CFG->libdir . '/questionlib.php');

global $DB;
$dao = new ks_question_categories();

$action = optional_param('action', "", PARAM_TEXT);
switch ($action){
    case "create" :
        $id  = optional_param('id', 0, PARAM_INT);
        $categoryId  = optional_param('categoryid', 0, PARAM_INT);
        $userId = optional_param('userid', 0, PARAM_INT);
        $name  = optional_param('name', 0, PARAM_TEXT);
        $info = optional_param('info', 0, PARAM_TEXT);
        $type = optional_param('type', 0, PARAM_INT);
        if($id && $id > 0){
            $question = $dao->updateCategory($id, $userId, $name, $info, $categoryId, $type);
        }else {
            $question = $dao->createCategory($userId, $name, $info, $categoryId, $type);
        }

        echo json_encode($question);
        break;

    case "list" :
        $categoryId  = optional_param('categoryid', 0, PARAM_INT);
        $userId = optional_param('userid', 0, PARAM_INT);
        if($categoryId && $categoryId > 0){
            $categories = $dao->loadCategoryByParent($categoryId);
            echo json_encode($categories);
        }else if($userId && $userId > 0){
            $categories = $dao->loadCategoryByUser($userId);
            echo json_encode($categories);
        }
        break;

    case "listWithType" :
        $userId = optional_param('userid', 0, PARAM_INT);
        $type = optional_param('type', 0, PARAM_INT);
        $questions = $dao->loadCategoryByTypeAndUser($userId, $type);
        json_encode($questions);
        break;

    case "one" :
        $id  = optional_param('id', 0, PARAM_INT);
        $category = $dao->loadCategory($id);
        echo json_encode($category);
        break;

    case "delete" :
        $id  = optional_param('id', 0, PARAM_INT);
        echo $dao->deleteCategory($id);
        break;
}



