<?php

/**
 * Created by PhpStorm.
 * User: xuan
 * Date: 29/12/2016
 * Time: 16:26
 */
class User
{

    public function getObjectUser($username, $password, $firstname, $lastname, $email)
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
}