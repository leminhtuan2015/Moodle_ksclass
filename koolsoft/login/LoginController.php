<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 1/5/17
 * Time: 4:26 PM
 */

require_once(__DIR__."/../../config.php");
require_once(__DIR__."/../application/ApplicationController.php");
require_once(__DIR__.'/../../login/lib.php');

class LoginController extends ApplicationController{

    function index(){
        if(isloggedin()){
            redirect("/moodle/koolsoft/login/logout.php");
        }

//        require_once ("./views/index.php");
        require_once ("./views/v1/index.php");
    }

    function login(){

        if(isloggedin()){
            redirect("/moodle/koolsoft/logout");
        }

        $username = $_POST["username"];
        $password = $_POST["password"];

        error_log(print_r($username, true));
        error_log(print_r($password, true));

        $user = authenticate_user_login($username, $password);

//        Logger::log($user);

        if($user){
            complete_user_login($user);
            \core\session\manager::apply_concurrent_login_limit($user->id, session_id());
            redirect("/moodle/koolsoft/");
        } else {
            redirect("/moodle/koolsoft/login");
        }
    }

    function newRegister(){

    }

}