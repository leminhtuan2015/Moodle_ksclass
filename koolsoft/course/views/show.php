<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:04 PM
 */

require_once(__DIR__."/../../shared/views/confirm.php");


// TODO CLEAN
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
if(isset($_POST['typeadd'])){
    $typeAdd = $_POST['typeadd'];
    if($typeAdd == "Label") {
        header("Location: /moodle/koolsoft/course/");
//          header("Location: http://localhost/moodle/koolsoft/course/");
    }
}

?>

<div class="container">
    <h2>Class: <span class="text-primary"><?php echo $course->fullname ?></span></h2>
    <div class="btn-group pull-right" role="group">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="/moodle/koolsoft/course/?action=edit&id=<?php echo $course->id ?>">Edit</a></li>
                <li>
                    <a data-toggle="modal" data-target="#confirm-delete"
                       data-href="/moodle/koolsoft/course/?action=delete&id=<?php echo $course->id ?>">Delete</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Lectures</a></li>
        <li><a data-toggle="tab" href="#menu1">Document</a></li>
        <li><a data-toggle="tab" href="#menu2">Posts</a></li>
        <li><a data-toggle="tab" href="#members">Members</a></li>
        <li><a data-toggle="tab" href="#questionBank">Members</a></li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <br>

            <div class="">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td>Name</td>
                        <td>Last modified</td>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($sections as $section) { ?>
                        <?php if($section->section == 0){continue;} ?>

                        <tr style="height: 50px">
                            <td>
                                <a href='/moodle/koolsoft/lecture/?action=show&id=<?php echo $section->id; ?>&courseId=<?php echo $course->id; ?>'>
                                    <?php echo $section->name; ?>
                                </a>
                                <br>
                                <p class='small lead'>Create by: <cite><a href="#">Owner</a></cite></p>
                            </td>
                            <td>
                                <p class='small lead'>2016/11/12</p>
                            </td>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
        <div id="menu1" class="tab-pane fade">
            <h3>Document</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="menu2" class="tab-pane fade">
            <br>
            <?php include (__DIR__."/../../shared/views/create_message_box.php"); ?>
        </div>
        <div id="members" class="tab-pane fade">
            <br>
            <div class="">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td>Name</td>
                        <td>Progress</td>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($enrolledUsers as $enrolledUser) { ?>
                        <tr style="height: 50px">
                            <td>
                                <a href="../../user/profile.php?id=<?php echo $enrolledUser->id ?>">
                                    <?php echo "$enrolledUser->username ($enrolledUser->email)" ?>
                                </a>
                            </td>
                            <td>
                                <p class='small lead'>progress...</p>
                            </td>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
