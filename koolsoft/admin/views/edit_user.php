<head>
    <style>
        #divContent {
            width: 80%;
            margin-left: 10%;
        }
        #text_alert{
            color: red;
        }
    </style>
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
 * Time: 20:47
 */
//require_once(__DIR__ . '/../../../admin/roles/lib.php');

?>

<div id="divContent">
    <form method="post" action="/moodle/koolsoft/admin/?action=editrole&id=<?php echo $id ?>">
        <br>
        <p id="text_alert"><?php echo $message ?></p>
        <div class="form-group">
            <label for="usr"> Username:</label>
            <input type="text" class="form-control input-lg" value="<?php echo array_values($userdata)[0]->username ?>"
                   name="username">
        </div>
        <div class="form-group">
            <label for="usr"> New password:</label>
            <input type="password" class="form-control input-lg" name="password">
        </div>
        <div class="form-group">
            <label for="usr"> FirstName:</label>
            <input type="text" class="form-control input-lg" value="<?php echo array_values($userdata)[0]->firstname ?>"
                   name="firstname">
        </div>
        <div class="form-group">
            <label for="usr"> Surname:</label>
            <input type="text" class="form-control input-lg" value="<?php echo array_values($userdata)[0]->lastname ?>"
                   name="surname">
        </div>
        <div class="form-group">
            <label for="usr"> Email Address:</label>
            <input type="text" class="form-control input-lg" value="<?php echo array_values($userdata)[0]->email ?>"
                   name="email">
        </div>
        <label class="checkbox-inline"><input type="checkbox" name="suppend" value="" <?php echo $suspended?>>Suspended account</label> <br>
        <label class="checkbox-inline"><input type="checkbox" name="manager" value="" <?php echo $is_manager?>>Manager</label> <br>
<!--        <select name="manager">-->
<!--            <option value="action">Action</option>-->
<!--            <option value="add">Assign manage</option>-->
<!--            <option value="remove">Remove manager</option>-->
<!--        </select><br>-->
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>


<?php


?>
