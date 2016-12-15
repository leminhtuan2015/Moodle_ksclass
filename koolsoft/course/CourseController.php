<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 9:41 PM
 */

require_once(__DIR__."/../application/ApplicationController.php");

class CourseController extends ApplicationController {
    public function index() {

        require_once(__DIR__.'/views/index.php');
    }
    public function show($id) {

        require_once(__DIR__.'/views/show.php');
    }
}