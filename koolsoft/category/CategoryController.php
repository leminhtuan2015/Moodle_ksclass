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
        $categories = $this->getAllCategories();
        $rootCategory = $this->getTreeCategory($categories);

        require_once(__DIR__.'/views/index.php');
    }

    public function edit($id){
        $categories = $this->getAllCategories();
        $categoriesName = $this->getPathCategory($categories);

//        error_log(print_r($categoriesName, true));

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
        $categories = $this->getAllCategories();
        $rootCategory = $this->getTreeCategory($categories);
        $coursesOfCategory = $this->getCoursesByCategoryId($id);

        require_once(__DIR__.'/views/index.php');
    }

//    PRIVATE ----------------------------------------------- PRIVATE

    public function getAllCategories(){
        global $DB;

//        $categorieslist = coursecat::make_categories_list('moodle/category:manage');
//        $categoryids = array_keys($categorieslist);
//        $categories = coursecat::get_many($categoryids);

        // Retrieve all categories in the database.
        $categories = $DB->get_records('course_categories');

//        error_log(print_r($categories, true));

        return $categories;
    }

    private function getTreeCategory($categories){
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

//        error_log(print_r($courses, true));

        return $courses;
    }

    public function getPathCategory($categories){
        $categoriesName = array();

        foreach ($categories as $category) {
            $categoriesName[$category->id] = $this->getCategoryNameByPath($categories, $category->path);
        }

        return $categoriesName;
    }

    private function getCategoryNameByPath($categories, $pathIds){
        $pathName = "";
        $pathIdArray = explode("/", $pathIds);

//        error_log(print_r($pathIdArray, true));

        foreach ($pathIdArray as $pathId) {
            $pathName = $pathName.$this->getCategoryNameById($categories, $pathId)."/";
        }

        return $pathName;
    }

    private function getCategoryNameById($categories, $categoryId){
        foreach ($categories as $category) {
            if($category->id == $categoryId){
                return $category->name;
            }
        }
    }

}