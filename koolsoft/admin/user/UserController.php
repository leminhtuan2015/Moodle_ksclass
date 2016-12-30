<?php
/**
 * Created by PhpStorm.
 * User: xuan
 * Date: 29/12/2016
 * Time: 15:52
 */

require_once(__DIR__."/../../application/ApplicationController.php");
require_once('../../../config.php');
require_once(__DIR__.'/../../../lib/adminlib.php');
require_once(__DIR__.'/../../../lib/authlib.php');
require_once(__DIR__.'/../../../user/filters/lib.php');
require_once(__DIR__.'/../../../user/lib.php');
require_once(__DIR__.'/../../../lib/outputrenderers.php');
require_once(__DIR__.'/../../../lib/gdlib.php');
require_once(__DIR__.'/../../../lib/adminlib.php');
require_once(__DIR__ . '/../../../admin/roles/lib.php');
require_once(__DIR__ . '/models/User.php');

class UserController extends  ApplicationController {

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
                redirect("/moodle/koolsoft/admin/user/?action=listuser&search=$search&filter=$filter");
            }else{
                redirect("/moodle/koolsoft/admin/user/?action=listuser&filter=$filter");
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
        $arrayData = $this->get_user_datas($search);
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


            $object_user = new User();
            $user = $object_user->getObjectUser($username, $password, $firstname, $lastname, $email);
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
                    redirect("/moodle/koolsoft/admin/user/?action=listuser");
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
                redirect("/moodle/koolsoft/admin/user/?action=listuser");
            }else{
                $message = $arrayCheck->message;
            }

        }


        require_once(__DIR__ . '/views/edit_user.php');
    }


    public function  get_user_datas($search) {
        if($id_delete && $tag){
            global $OUTPUT;
//    error_log(print_r(md5($id_delete), true));
            $returnurl = "/koolsoft/admin/user/?action=listuser";
            $fullname = "Delete test";
            $optionsyes = array('delete'=>$id_delete, 'confirm'=>md5($id_delete), 'sesskey'=>sesskey());
            $deleteurl = new moodle_url($returnurl, $optionsyes);
            $deletebutton = new single_button($deleteurl, get_string('delete'), 'post');
            echo $OUTPUT->confirm(get_string('deletecheckfull', '', "'$fullname'"), $deletebutton, $returnurl);
        }

        $sitecontext = context_system::instance();
        $context = context_system::instance();
        $extracolumns = get_extra_user_fields($context);
// Get all user name fields as an array.
        $allusernamefields = get_all_user_name_fields(false, null, null, null, true);
        $columns = array_merge($allusernamefields, $extracolumns, array('city', 'country', 'lastaccess'));
// create the user filter form
        $ufiltering = new user_filtering();
        foreach ($columns as $column) {
            $string[$column] = get_user_field_name($column);
            if ($sort != $column) {
                $columnicon = "";
                if ($column == "lastaccess") {
                    $columndir = "DESC";
                } else {
                    $columndir = "ASC";
                }
            } else {
                $columndir = $dir == "ASC" ? "DESC":"ASC";
                if ($column == "lastaccess") {
                    $columnicon = ($dir == "ASC") ? "sort_desc" : "sort_asc";
                } else {
                    $columnicon = ($dir == "ASC") ? "sort_asc" : "sort_desc";
                }
                $columnicon = "<img class='iconsort' src=\"" . $OUTPUT->pix_url('t/' . $columnicon) . "\" alt=\"\" />";

            }
            $$column = "<a href=\"user.php?sort=$column&amp;dir=$columndir\">".$string[$column]."</a>$columnicon";
        }

        $fullnamesetting = $CFG->alternativefullnameformat;
// If we are using language or it is empty, then retrieve the default user names of just 'firstname' and 'lastname'.
        if ($fullnamesetting == 'language' || empty($fullnamesetting)) {
            // Set $a variables to return 'firstname' and 'lastname'.
            $a = new stdClass();
            $a->firstname = 'firstname';
            $a->lastname = 'lastname';
            // Getting the fullname display will ensure that the order in the language file is maintained.
            $fullnamesetting = get_string('fullnamedisplay', null, $a);
        }

// Order in string will ensure that the name columns are in the correct order.
        $usernames = order_in_string($allusernamefields, $fullnamesetting);
        $fullnamedisplay = array();
        foreach ($usernames as $name) {
            // Use the link from $$column for sorting on the user's name.
            $fullnamedisplay[] = ${$name};
        }
        $fullnamedisplay = implode(' / ', $fullnamedisplay);
        if ($sort == "name") {
            // Use the first item in the array.
            $sort = reset($usernames);
        }

        list($extrasql, $params) = $ufiltering->get_sql_filter();
        $params['ex_text0'] = "%".$search."%";
        $users = get_users_listing($sort, $dir, $page*$perpage, $perpage, '', '', '',
            $extrasql, $params, $context);
        $usercount = get_users(false);
        $usersearchcount = get_users(false, '', false, null, "", '', '', '', '', '*', $extrasql, $params);


        $strall = get_string('all');


        flush();
        $countries = get_string_manager()->get_list_of_countries(false);
        foreach ($users as $key => $user) {
            if (isset($countries[$user->country])) {
                $users[$key]->country = $countries[$user->country];
            }
        }
        if ($sort == "country") {  // Need to resort by full country name, not code
            foreach ($users as $user) {
                $susers[$user->id] = $user->country;
            }
            asort($susers);
            foreach ($susers as $key => $value) {
                $nusers[] = $users[$key];
            }
            $users = $nusers;
        }

        $table = new html_table();
        $table->head = array ();
        $table->colclasses = array();
        $table->head[] = $fullnamedisplay;
        $table->attributes['class'] = 'admintable generaltable';
        foreach ($extracolumns as $field) {
            $table->head[] = ${$field};
        }
        $table->head[] = $city;
        $table->head[] = $country;
        $table->head[] = $lastaccess;
        $table->head[] = get_string('edit');
        $table->colclasses[] = 'centeralign';
        $table->head[] = "";
        $table->colclasses[] = 'centeralign';

        $table->id = "users";
        foreach ($users as $user) {
            $buttons = array();
            $lastcolumn = '';
            if ($user->lastaccess) {
                $strlastaccess = format_time(time() - $user->lastaccess);
            } else {
                $strlastaccess = get_string('never');
            }
            $fullname = fullname($user, true);

            $row = array ();
            $row[] = "<a href=\"../user/view.php?id=$user->id&amp;course=$site->id\">$fullname</a>";
            foreach ($extracolumns as $field) {
                $row[] = $user->{$field};
            }
            $row[] = $user->city;
            $row[] = $user->country;
            $row[] = $strlastaccess;
            if ($user->suspended) {
                foreach ($row as $k=>$v) {
                    $row[$k] = html_writer::tag('span', $v, array('class'=>'usersuspended'));
                }
            }
            $row[] = implode(' ', $buttons);
            $row[] = $lastcolumn;
            $table->data[] = $row;
        }

        $arrayData = $table->data;
        return $arrayData;
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