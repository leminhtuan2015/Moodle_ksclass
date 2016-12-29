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

<div id="divBody">
    <div>
        <form method="post" action="/moodle/koolsoft/admin/user/?action=listuser">
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
        location.href = "/moodle/koolsoft/admin/user/?action=adduser";
    }
    function onclickEdit(id){
        location.href = "/moodle/koolsoft/admin/user/?action=editrole&id=" +id;
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