<?php
/**
 * Created by PhpStorm.
 * User: xuan
 * Date: 27/12/2016
 * Time: 14:07
 */
require_once(__DIR__."/../application/ApplicationController.php");
require_once('../../config.php');
require_once(__DIR__.'/../../lib/adminlib.php');
require_once(__DIR__.'/../../lib/authlib.php');
require_once(__DIR__.'/../../user/filters/lib.php');
require_once(__DIR__.'/../../user/lib.php');

require_once(__DIR__.'/../../lib/gdlib.php');
require_once(__DIR__.'/../../lib/adminlib.php');
require_once(__DIR__.'/../../user/editadvanced_form.php');
require_once(__DIR__.'/../../user/editlib.php');
require_once(__DIR__.'/../../user/profile/lib.php');
require_once(__DIR__.'/../../user/lib.php');
require_once(__DIR__.'/../../webservice/lib.php');


class AdminController extends  ApplicationController {


    function __construct() {
        parent::__construct();
    }

    public function index() {
        require_once(__DIR__.'/views/index.php');
    }

    public function show_list_user(){
        require_once(__DIR__.'/views/list_user.php');
    }

    public function add_new_user() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            //check data received
            echo "add user";
            if (!empty($_POST["username"])) {
                $username = $_POST["username"];
            }
            if (!empty($_POST["password"])) {
                $password = $_POST["password"];
            }
            if (!empty($_POST["firstname"])) {
                $firstname = $_POST["firstname"];
            }
            if (!empty($_POST["surname"])) {
                $lastname = $_POST["surname"];
            }
            if (!empty($_POST["email"])) {
                $email = $_POST["email"];
            }
        }
        require_once(__DIR__.'/views/add_new_user.php');
    }

}