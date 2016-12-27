<?php
/**
 * Created by PhpStorm.
 * User: xuan
 * Date: 27/12/2016
 * Time: 14:17
 */

//require_once(__DIR__.'/../../../config.php');
//require_once(__DIR__.'/../../../lib/adminlib.php');
//require_once(__DIR__.'/../../../lib/authlib.php');
//require_once(__DIR__.'/../../../user/filters/lib.php');
//require_once(__DIR__.'/../../../user/lib.php');



echo "list user";

$sitecontext = context_system::instance();
$context = context_system::instance();
$extracolumns = get_extra_user_fields($context);
// Get all user name fields as an array.
$allusernamefields = get_all_user_name_fields(false, null, null, null, true);
$columns = array_merge($allusernamefields, $extracolumns, array('city', 'country', 'lastaccess'));
// create the user filter form
$ufiltering = new user_filtering();
foreach ($columns as $column) {
    error_log(print_r("kkkkkkkkkkkkkkkk", true));
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
    error_log(print_r("mmmmmmmmm", true));
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
    error_log(print_r("nnnnnnnnnn", true));
    // Use the link from $$column for sorting on the user's name.
    $fullnamedisplay[] = ${$name};
}
$fullnamedisplay = implode(' / ', $fullnamedisplay);
if ($sort == "name") {
    // Use the first item in the array.
    $sort = reset($usernames);
}

list($extrasql, $params) = $ufiltering->get_sql_filter();
$users = get_users_listing($sort, $dir, $page*$perpage, $perpage, '', '', '',
    $extrasql, $params, $context);
$usercount = get_users(false);
$usersearchcount = get_users(false, '', false, null, "", '', '', '', '', '*', $extrasql, $params);


$strall = get_string('all');


flush();
    $countries = get_string_manager()->get_list_of_countries(false);
    foreach ($users as $key => $user) {
        if (isset($countries[$user->country])) {
            error_log(print_r("yyyyyyyy", true));
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
            error_log(print_r("666666666", true));
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
error_log(print_r($table, true));
echo html_writer::table($table);
?>
<button id="btnAddNew" type="button" class="btn btn-default">Add new user</button>
<script>
    var btnAddNew = document.getElementById('btnAddNew');
    btnAddNew.onclick = function () {
        location.href = "/moodle/koolsoft/admin/?action=adduser";
    }
</script>
