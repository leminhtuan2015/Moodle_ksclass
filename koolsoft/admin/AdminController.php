<head>
    <script>
        function back_to_list() {
            location.href = "/moodle/koolsoft/admin/?action=listuser";
        }
    </script>
</head>
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
require_once(__DIR__.'/../../lib/outputrenderers.php');
require_once(__DIR__.'/../../lib/gdlib.php');
require_once(__DIR__.'/../../lib/adminlib.php');
require_once(__DIR__ . '/../../admin/roles/lib.php');



class AdminController extends  ApplicationController {


    function __construct() {
        parent::__construct();
    }

    public function index() {
        require_once(__DIR__.'/views/index.php');
    }

    public function show_list_user(){
        $filter = "all";
        if($_GET['id']){
            $id_delete = $_GET['id'];
        }
        if($_GET['tag']){
            $tag = $_GET['tag'];
        }
        if($_GET['search']){
            $search = $_GET['search'];
        }
        if($_GET['filter']){
            $filter = $_GET['filter'];
        }
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            if (isset($_POST["filter"])) {
                $filter = $_POST["filter"];
            }
            if (!empty($_POST["text_filter"])) {
                $search = $_POST["text_filter"];
                header("Location:/moodle/koolsoft/admin/?action=listuser&search=$search&filter=$filter");
            }else{
                header("Location:/moodle/koolsoft/admin/?action=listuser&filter=$filter");
            }
        }
        $all_select = "";
        $manager_select = "";
        $student_select = "";
        $suppend_select = "";
        if($filter == "all"){
            $all_select = "selected";
        }else if ($filter == "manager"){
            $manager_select = "selected";
        }else if ($filter == "student") {
            $student_select = "selected";
        }else if ($filter == "suppended") {
            $suppend_select = "selected";
        }
        require_once(__DIR__.'/views/list_user.php');
    }

    public function add_new_user() {
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            //check data received
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
            $systemcontext = context_system::instance();
            $user = $this->getObjectUser($username, $password, $firstname, $lastname, $email);
            $authplugin = get_auth_plugin($user->auth);
            $arrayCheck = $this->checkCreateUserData($username, $password, $firstname, $lastname, $email);
            if ($arrayCheck->check == "true") {
                if ($user->id == -1) {
                    $user->confirmed = 1;
                    $user->timecreated = time();
                    if ($authplugin->is_internal()) {
                        $user->password = hash_internal_user_password($user->newpassword);
                    } else {
                        $user->password = AUTH_PASSWORD_NOT_CACHED;
                    }
                    user_create_user($user, false, false);
                    echo '<script> back_to_list(); </script>';
                }
            }else{
                $message = $arrayCheck->message;
            }
        }
        require_once(__DIR__.'/views/create_user.php');
    }

    public function  edit_role(){
        $id = optional_param('id', 0, PARAM_INT);
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
        if (!empty($_POST["assign"])) {
            $assign = $_POST["assign"];
        }
        if (!empty($_POST["remove"])) {
            $remove = $_POST["remove"];
        }
        if (isset($_POST["suppend"])) {
            $suppend = "checked";
        }
        if (isset($_POST["manager"])) {
            $manager = "checked";
        }else{
            $manager = "";
        }

        $roleid = 1;
        $contextid = 1;
        list($context, $course, $cm) = get_context_info_array($contextid);

        if ($id) {
            $userdata = $this->get_user_from_id($id);
            $suspended = array_values($userdata)[0]->suspended;
            if($suspended == 0){
                $suspended = "";
            }else{
                $suspended = "checked";
            }
            $is_manager =  ClientUtil::is_manager();
            if($is_manager == 1){
                $is_manager = "checked";
            }else{
                $is_manager = "";
            }
        }
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if ($manager == "checked") {
                role_assign($roleid, $id, $context->id);
            } else  {
                role_unassign($roleid, $id, $context->id, '');
            }
            $arrayCheck = $this->checkUserData($username, $password, $firstname, $lastname, $email);
            if ($arrayCheck->check == "true" && isset($id)) {
                $useredit = $this->get_user_from_id($id);
                $userdata = array_values($userdata)[0];
                $userdata->confirmed = 1;
                $userdata->timecreated = time();
                $userdata->email = $email;
                $userdata->firstname = $firstname;
                $userdata->lastname = $lastname;
                if($suppend == "checked"){
                    $userdata->suspended = 1;
                }else{
                    $userdata->suspended = 0;
                }

                if(isset($password)){
                    $userdata->newpassword = $password;
                    $authplugin = get_auth_plugin($userdata->auth);
                    if ($authplugin->is_internal()) {
                        $userdata->password = hash_internal_user_password($userdata->newpassword);
                    } else {
                        $userdata->password = AUTH_PASSWORD_NOT_CACHED;
                    }
                }
                user_update_user($userdata, false, false);
                echo '<script> back_to_list(); </script>';
            }else{
                $message = $arrayCheck->message;
            }

        }


        require_once(__DIR__ . '/views/edit_user.php');
    }

    public function  is_manager($firstname,$lastname){
        $name = $firstname ." " .$lastname;
        $array_manager = $this->get_array_manager();
        foreach ($array_manager as $item){
            if($item.trim() == $name.trim()){
                return "true";
            }
        }
        return "false";
    }
    function get_user_from_id($id)
    {
        global $DB;
        $sql = 'SELECT * FROM ks_user WHERE id =' . $id;
        $param = array();
        $userdata = $DB->get_records_sql($sql, $param);
        return $userdata;
    }

    function checkUserData($username, $password, $firstname, $lastname, $email)
    {
        $arrayCheck = new stdClass();
        $arrayCheck->check = "true";
        $arrayCheck->message = "";
        if (is_null($username) || strlen($username) == 0) {
            $arrayCheck->check = "false";
            $arrayCheck->message = "Bạn chưa nhập username";
            return $arrayCheck;
        }else  if (is_null($firstname) || strlen($firstname) == 0) {
            $arrayCheck->check = "false";
            $arrayCheck->message = "Bạn chưa nhập firstname";
            return $arrayCheck;
        } else if (is_null($lastname) || strlen($lastname) == 0) {
            $arrayCheck->check = "false";
            $arrayCheck->message = "Bạn chưa nhập lastname";
            return $arrayCheck;
        } else if (is_null($email) || strlen($email) == 0) {
            $arrayCheck->check = "false";
            $arrayCheck->message = "Bạn chưa nhập email";
            return $arrayCheck;
        } else if (preg_match('/[A-Z]/', $username)) {
            $arrayCheck->check = "false";
            $arrayCheck->message = "Username chỉ được để chữ thường";
        } else if(isset($password)){
            if (!preg_match('/[A-Z]/', $password) || !preg_match('/[!@#$%^&*()]/', $password) || !preg_match('/[0-9]/', $password)) {
                $arrayCheck->check = "false";
                $arrayCheck->message = "Password phải có ít nhất 8 ký tự,ít nhất một số,it nhất một từ viết hoa và ít nhất 1 ký tự đặc biệt như !,@,#,$";
            }
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $arrayCheck->check = "false";
            $arrayCheck->message = "Email không đúng định dạng";
        }

        return $arrayCheck;
    }
    function getObjectUser($username, $password, $firstname, $lastname, $email)
    {
        $user = new stdClass();
        $user->course = 1;
        $user->username = $username;
        $user->auth = 'manual';
        $user->suspended = 0;
        $user->newpassword = $password;
        $user->preference_auth_forcepasswordchange = 0;
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->maildisplay = 2;
        $user->timezone = 1;
        $user->mform_isexpanded_id_moodle_picture = 1;
        $user->imagefile = 866746015;
        $user->submitbutton = "Create user";
        $user->timemodified = 1482808436;
        $user->descriptiontrust = 0;
        $user->descriptionformat = 1;
        $user->mnethostid = 1;
        $user->confirmed = 1;
        $user->timecreated = 1482808436;
        $user->password = '$2y$10$kBO0dTCFa7m8xggehh92r.FG/jt4K6KNX3QvXJ8OS2BDHkYmZj2yi';
        $user->calendartype = 'gregorian';
        $user->mailformat = 1;
        $user->maildigest = 0;
        $user->autosubscribe = 1;
        $user->trackforums = 0;
        $user->lang = 'en';
        $user->id = -1;
        return $user;
    }

    function checkCreateUserData($username, $password, $firstname, $lastname, $email)
    {
        $arrayCheck = new stdClass();
        $arrayCheck->check = "true";
        $arrayCheck->message = "";
        if (is_null($username) || strlen($username) == 0) {
            $arrayCheck->check = "false";
            $arrayCheck->message = "Bạn chưa nhập username";
            return $arrayCheck;
        }else
            if (is_null($password) || strlen($password) == 0) {
                $arrayCheck->check = "false";
                $arrayCheck->message = "Bạn chưa nhập password";
                return $arrayCheck;
            }else if (is_null($firstname) || strlen($firstname) == 0) {
                $arrayCheck->check = "false";
                $arrayCheck->message = "Bạn chưa nhập firstname";
                return $arrayCheck;
            }else if (is_null($lastname) || strlen($lastname) == 0) {
                $arrayCheck->check = "false";
                $arrayCheck->message = "Bạn chưa nhập lastname";
                return $arrayCheck;
             }else if (is_null($email) || strlen($email) == 0) {
                $arrayCheck->check = "false";
                $arrayCheck->message = "Bạn chưa nhập email";
                return $arrayCheck;
             }else if (preg_match('/[A-Z]/', $username)) {
                 $arrayCheck->check = "false";
                 $arrayCheck->message = "Username chỉ được để chữ thường";
              }else if (!preg_match('/[A-Z]/', $password) || !preg_match('/[!@#$%^&*()]/', $password) || !preg_match('/[0-9]/', $password)) {
                 $arrayCheck->check = "false";
                 $arrayCheck->message = "Password phải có ít nhất 8 ký tự,ít nhất một số,it nhất một từ viết hoa và ít nhất 1 ký tự đặc biệt như !,@,#,$";
             }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                 $arrayCheck->check = "false";
                 $arrayCheck->message = "Email không đúng định dạng";
              }

        return $arrayCheck;
    }

}