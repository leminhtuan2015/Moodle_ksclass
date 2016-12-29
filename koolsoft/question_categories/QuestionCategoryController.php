<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/27/16
 * Time: 9:21 AM
 */

require_once("../../config.php");
require_once(__DIR__."/../application/ApplicationController.php");
require_once(__DIR__."/models/ks_question_categories.php");
class QuestionCategoryController extends ApplicationController{

    function __construct() {
        parent::__construct();
    }

    public function index() {
        require_once(__DIR__.'/views/index.php');
    }

    public function show($id) {
        global $USER;
        $dao = new ks_question_categories();
        $categories = null;
        if(!$id || $id == 0){
            $categories = $dao->loadCategoryByUser($USER->id);
            if(count($categories) == 0){
                $dao->createCategory($USER->id, "Default", "Default", 0);
                $categories = $dao->loadCategoryByUser($USER->id);
            }
        }else {
            $categories = $dao->loadCategoryByParent($id);
        }

        require_once(__DIR__.'/views/show.php');
    }


}