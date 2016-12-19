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
require_once(__DIR__."/models/Category.php");

class CategoryController extends ApplicationController {

    function __construct() {
        parent::__construct();
    }

    public function index(){
        $rootCategory = new Category();
        $rootCategory = $this->getAllCategories();

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

    public function show($id){
        $rootCategory = new Category();
        $rootCategory = $this->getAllCategories();
        $coursesOfCategory = $this->getCoursesByCategoryId($id);

        require_once(__DIR__.'/views/index.php');
    }

    private function getAllCategories(){
        $categorieslist = coursecat::make_categories_list('moodle/category:manage');
        $categoryids = array_keys($categorieslist);
        $categories = coursecat::get_many($categoryids);

//        error_log(print_r($categories, true));

        $rootCategory = new Category();

        $this->treeCategory($categories, $rootCategory);

        return $rootCategory;
    }

    private function treeCategory($categories, $rootCategory){
        foreach ($categories as $c) {
            if($c->parent == $rootCategory->id){
//                echo "$c->id";

                $category = new Category();
                $category->id = $c->id;
                $category->name = $c->name;

                array_push($rootCategory->childrent, $category);

                $this->treeCategory($categories, $category);
            }
        }
    }

    private function getCoursesByCategoryId($categoryId){

        $courses = get_courses($categoryId);

        error_log(print_r($courses, true));

        return $courses;
    }

}