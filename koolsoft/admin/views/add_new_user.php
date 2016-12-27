<?php
/**
 * Created by PhpStorm.
 * User: xuan
 * Date: 27/12/2016
 * Time: 15:08
 */

//require_once(__DIR__.'/../../../config.php');
//require_once(__DIR__.'/../../../lib/gdlib.php');
//require_once(__DIR__.'/../../../lib/adminlib.php');
//require_once(__DIR__.'/../../../user/editadvanced_form.php');
//require_once(__DIR__.'/../../../user/editlib.php');
//require_once(__DIR__.'/../../../user/profile/lib.php');
//require_once(__DIR__.'/../../../user/lib.php');
//require_once(__DIR__.'/../../../webservice/lib.php');


if($_SERVER['REQUEST_METHOD'] == "POST") {
    error_log(print_r("Start post request", true));
    $systemcontext = context_system::instance();
    $user = getObjectUser($username,$password,$firstname,$lastname,$email);
    $usercontext = context_user::instance($user->id);
    $editoroptions = array(
        'maxfiles'   => EDITOR_UNLIMITED_FILES,
        'maxbytes'   => $CFG->maxbytes,
        'trusttext'  => false,
        'forcehttps' => false,
        'context'    => $usercontext
    );
    $authplugin = get_auth_plugin($user->auth);
//    $check = checkUserData($username,$password,$firstname,$lastname,$email);
//    var_dump($check);
//    if($check == true) {
        if ($user->id == -1) {
            error_log(print_r("userid = -1", true));
            unset($user->id);
            error_log(print_r("111", true));
            $createpassword = !empty($user->createpassword);
            error_log(print_r("2222", true));
            unset($user->createpassword);
            error_log(print_r("333", true));
            $user = file_postupdate_standard_editor($user, 'description', $editoroptions, null, 'user', 'profile', null);
            error_log(print_r($user, true));
            $user->mnethostid = $CFG->mnet_localhost_id; // Always local user.
            $user->confirmed = 1;
            $user->timecreated = time();
            error_log(print_r("444", true));
            if ($authplugin->is_internal()) {
                error_log(print_r("5555", true));
                if ($createpassword or empty($user->newpassword)) {
                    $user->password = '';
                } else {
                    $user->password = hash_internal_user_password($user->newpassword);
                }
            } else {
                $user->password = AUTH_PASSWORD_NOT_CACHED;
            }
            error_log(print_r("Start create user", true));
            user_create_user($user, false, false);
            error_log(print_r($user, true));
        }
    }
?>

<div>
    <form action="/moodle/koolsoft/admin/?action=adduser" method="post">
        Username:
        <input type="text" name="username"> </br>
        New password:
        <input type="text" name="password"> </br>
        FirstName:
        <input type="text" name="firstname"> </br>
        Surname:
        <input type="text" name="surname"> </br>
        Email Address:
        <input type="text" name="email"> </br>

        <input type="submit" name="addnewuser" value="Create user">
    </form>
</div>

<?php
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

function checkUserData($username, $password, $firstname, $lastname, $email)
{
    $arrayCheck = array();
    $arrayCheck['check'] = true;
    $arrayCheck['message'] = "";
    if (is_null($username) || strlen($username) == 0) {
        $arrayCheck['check'] = false;
        $arrayCheck['message'] = "Bạn chưa nhập username";
        return $arrayCheck;
    }
    if (is_null($password) || strlen($password) == 0) {
        $arrayCheck['check'] = false;
        $arrayCheck['message'] = "Bạn chưa nhập password";
        return $arrayCheck;
    }
    if (is_null($firstname) || strlen($firstname) == 0) {
        $arrayCheck['check'] = false;
        $arrayCheck['message'] = "Bạn chưa nhập firstname";
        return $arrayCheck;
    }
    if (is_null($lastname) || strlen($lastname) == 0) {
        $arrayCheck['check'] = false;
        $arrayCheck['message'] = "Bạn chưa nhập lastname";
        return $arrayCheck;
    }
    if (is_null($email) || strlen($email) == 0) {
        $arrayCheck['check'] = false;
        $arrayCheck['message'] = "Bạn chưa nhập email";
        return $arrayCheck;
    }
    if (preg_match('/[A-Z]/', $username)) {
        $arrayCheck['check'] = false;
        $arrayCheck['message'] = "Username chỉ được để chữ thường";
    }

    return $arrayCheck;
}

?>
