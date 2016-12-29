<head>
    <style>
        #divFrom {
            width: 80%;
            margin-left: 10%;
        }
        #divP{
            width: 20%;
            display: inline-block;
            margin-bottom: 10px;
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
<div id="divFrom">
    <form action="/moodle/koolsoft/admin/?action=adduser" method="post" autocomplete="off">
        <p id="text_alert"><?php echo $message ?></p>
        <div class="form-group" aria-autocomplete="none">
            <label for="usr"> Username:</label>
            <input type="text" class="form-control input-lg"  name="username" value="<?php echo $username?>" autocomplete="off" >
        </div>
        <div class="form-group">
            <label for="usr"> New password:</label>
            <input type="password" class="form-control input-lg" value="<?php echo $password?>" name="password">
        </div>
        <div class="form-group">
            <label for="usr"> FirstName:</label>
            <input type="text" class="form-control input-lg" value="<?php echo $firstname?>" name="firstname">
        </div>
        <div class="form-group">
            <label for="usr">  Surname:</label>
            <input type="text" class="form-control input-lg" value="<?php echo $lastname?>" name="surname">
        </div>
        <div class="form-group">
            <label for="usr">   Email Address:</label>
            <input type="text" class="form-control input-lg" value="<?php echo $email?>" name="email">
        </div>

        <button type="submit" class="btn btn-default">Create user</button>


    </form>
</div>


<?php


?>
