<head>
    <style>
        #divBody{
            width: 80%;
            margin-left: 10%;
        }
        #btnAddNew{
            float: right;
            margin-right: 10%;
        }
    </style>
</head>
<?php
/**
 * Created by PhpStorm.
 * User: xuan
 * Date: 27/12/2016
 * Time: 14:17
 */

if($id_delete && $tag){
    global $OUTPUT;
//    error_log(print_r(md5($id_delete), true));
    $returnurl = "/koolsoft/admin/?action=listuser";
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

?>
<div id="divBody">
    <div>
        <form method="post" action="/moodle/koolsoft/admin/?action=listuser">
            <div class="form-group">
                <label for="usr">Type text:</label>
                <input type="text" class="form-control" name="text_filter" value="<?php echo $search?>">
            </div>
            <button type="submit" class="btn btn-success">Search</button></br>
            <select name="filter">
                <option value="all" <?php echo $all_select?> >All</option>
                <option value="manager" <?php echo $manager_select?>>Manager</option>
                <option value="student" <?php echo $student_select?>>Student</option>
                <option value="suppended" <?php echo $suppend_select?>>Suppended</option>
            </select><br>
        </form>
    </div>
    <button id="btnAddNew" type="button" class="btn btn-primary">Add new user</button>
    <div id="divTable">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Firstname</th>
                <th>Email Address</th>
                <th>City/town</th>
                <th>Country</th>
                <th>Lass access</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(is_array($arrayData)){
                if($filter == "all"){
                    foreach ($arrayData as $item){
                        $id = getid_from_url($item['0']);
                        echo "<tr>";
                        if(ClientUtil::user_ismanager($id) == 1){
                            echo "<td><font color=\"#AF002A\"> " . $item['0'] . "</font></td>";
                            echo "<td><font color=\"#AF002A\">" . $item['1'] . "</font></td>";
                            echo "<td><font color=\"#AF002A\">" . $item['2'] . "</font></td>";
                            echo "<td><font color=\"#AF002A\">" . $item['3'] . "</font></td>";
                            echo "<td><font color=\"#AF002A\">" . $item['4'] . "</font></td>";
                        }else if(strpos($item['0'],"usersuspended") == true){
                            echo "<td><font color=\"#000000\"> " . $item['0'] . "</font></td>";
                            echo "<td><font color=\"#000000\">" . $item['1'] . "</font></td>";
                            echo "<td> <font color=\"#000000\">" . $item['2'] . "</font></td>";
                            echo "<td> <font color=\"#000000\">" . $item['3'] . "</font></td>";
                            echo "<td> <font color=\"#000000\">" . $item['4'] . "</font></td>";
                        }else {
                            echo "<td><font color=\"#5D7B9D\"> " . $item['0'] . "</font></td>";
                            echo "<td><font color=\"#5D7B9D\">" . $item['1'] . "</font></td>";
                            echo "<td> <font color=\"#5D7B9D\">" . $item['2'] . "</font></td>";
                            echo "<td> <font color=\"#5D7B9D\">" . $item['3'] . "</font></td>";
                            echo "<td> <font color=\"#5D7B9D\">" . $item['4'] . "</font></td>";
                        }

                        echo "<td>"."<button onclick=\"onclickEdit(".$id.")\" type=\"button\" class=\"btn btn-default\">Edit</button>"."</td>";
                        echo "<td>"."<button onclick=\"onclickDelete(".$id.")\" type=\"button\" class=\"btn btn-default\">Delete</button>"."</td>";
                        echo "</tr>";
                    }
                }else if($filter == "manager") {
                    foreach ($arrayData as $item){
                        $id = getid_from_url($item['0']);
                        if(ClientUtil::user_ismanager($id) == 1){
                            echo "<tr>";
                            echo "<td><font color=\"#AF002A\"> " . $item['0'] . "</font></td>";
                            echo "<td><font color=\"#AF002A\">" . $item['1'] . "</font></td>";
                            echo "<td><font color=\"#AF002A\">" . $item['2'] . "</font></td>";
                            echo "<td><font color=\"#AF002A\">" . $item['3'] . "</font></td>";
                            echo "<td><font color=\"#AF002A\">" . $item['4'] . "</font></td>";
                            echo "<td>"."<button onclick=\"onclickEdit(".$id.")\" type=\"button\" class=\"btn btn-default\">Edit</button>"."</td>";
                            echo "<td>"."<button onclick=\"onclickDelete(".$id.")\" type=\"button\" class=\"btn btn-default\">Delete</button>"."</td>";
                            echo "</tr>";
                        }
                    }
                }else if ($filter == "student") {
                    foreach ($arrayData as $item){
                        $id = getid_from_url($item['0']);
                        if(ClientUtil::user_ismanager($id) != 1){
                            echo "<tr>";
                            if(strpos($item['0'],"usersuspended") == true){
                                echo "<td><font color=\"#000000\"> " . $item['0'] . "</font></td>";
                                echo "<td><font color=\"#000000\">" . $item['1'] . "</font></td>";
                                echo "<td> <font color=\"#000000\">" . $item['2'] . "</font></td>";
                                echo "<td> <font color=\"#000000\">" . $item['3'] . "</font></td>";
                                echo "<td> <font color=\"#000000\">" . $item['4'] . "</font></td>";
                            }else {
                                echo "<td><font color=\"#5D7B9D\"> " . $item['0'] . "</font></td>";
                                echo "<td><font color=\"#5D7B9D\">" . $item['1'] . "</font></td>";
                                echo "<td> <font color=\"#5D7B9D\">" . $item['2'] . "</font></td>";
                                echo "<td> <font color=\"#5D7B9D\">" . $item['3'] . "</font></td>";
                                echo "<td> <font color=\"#5D7B9D\">" . $item['4'] . "</font></td>";
                            }

                            echo "<td>"."<button onclick=\"onclickEdit(".$id.")\" type=\"button\" class=\"btn btn-default\">Edit</button>"."</td>";
                            echo "<td>"."<button onclick=\"onclickDelete(".$id.")\" type=\"button\" class=\"btn btn-default\">Delete</button>"."</td>";
                            echo "</tr>";
                        }

                    }
                }else if ($filter == "suppended") {
                    foreach ($arrayData as $item){
                        $id = getid_from_url($item['0']);
                        if(strpos($item['0'],"usersuspended") == true){
                            echo "<tr>";
                            echo "<td><font color=\"#000000\"> " . $item['0'] . "</font></td>";
                            echo "<td><font color=\"#000000\">" . $item['1'] . "</font></td>";
                            echo "<td> <font color=\"#000000\">" . $item['2'] . "</font></td>";
                            echo "<td> <font color=\"#000000\">" . $item['3'] . "</font></td>";
                            echo "<td> <font color=\"#000000\">" . $item['4'] . "</font></td>";
                            echo "<td>"."<button onclick=\"onclickEdit(".$id.")\" type=\"button\" class=\"btn btn-default\">Edit</button>"."</td>";
                            echo "<td>"."<button onclick=\"onclickDelete(".$id.")\" type=\"button\" class=\"btn btn-default\">Delete</button>"."</td>";
                            echo "</tr>";
                        }
                    }
                }

            }
            ?>
            </tbody>
        </table>
    </div>

</div>
<script>
    var btnAddNew = document.getElementById('btnAddNew');
    btnAddNew.onclick = function () {
        location.href = "/moodle/koolsoft/admin/?action=adduser";
    }
    function onclickEdit(id){
        location.href = "/moodle/koolsoft/admin/?action=editrole&id=" +id;
    }
    function onclickDelete(id){
//        location.href = "/moodle/koolsoft/admin/?action=listuser&id=" +id+"&tag=delete";
    }
</script>
<?php
    function getid_from_url($url){
        return substr($url,strpos($url,'id')+3,strpos($url,'&amp') - strpos($url,'id') -3);
    }
?>