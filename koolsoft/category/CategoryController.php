<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/17/16
 * Time: 2:25 PM
 */

require_once("../../config.php");
require_once($CFG->dirroot. '/course/lib.php');
require_once($CFG->libdir. '/coursecatlib.php');
require_once(__DIR__."/../application/ApplicationController.php");

class CategoryController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index(){
        $categorieslist = coursecat::make_categories_list('moodle/category:manage');
        $categoryids = array_keys($categorieslist);
        $categories = coursecat::get_many($categoryids);

//        error_log(print_r($categories, true));

        $this->treeCategory($categories, 0);

        require_once(__DIR__.'/views/index.php');
    }

    public function edit($id){
        require_once(__DIR__.'/views/edit.php');
    }

    public function create(){
//        error_log(print_r($_POST, true));
        $data = array("parent" => $_POST["parentId"], "name" => $_POST["name"]);
        $category = coursecat::create($data);

        if($category){
            redirect("/moodle/koolsoft/category");
        }
    }

    private function treeCategory($categories, $rootId){
        $parentCategories = array();

        foreach ($categories as $category) {
            if($category->parent == $rootId){
                echo "$category->id";

                array_push($parentCategories, $category);
            }
        }

        if(count($parentCategories) > 0){

//            error_log(print_r($parentCategories, true));

            foreach ($parentCategories as $category) {
                echo "sub of $category->id";
                $this->treeCategory($categories, $category->id);
            }
        }
    }

}