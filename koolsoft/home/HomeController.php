<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:14 PM
 */

require_once(__DIR__."/../application/ApplicationController.php");

class HomeController extends ApplicationController {

    public function index(){
        require_once(__DIR__.'/views/index.php');
    }

}