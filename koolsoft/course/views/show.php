<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:04 PM
 */

require_once(__DIR__."/../../shared/views/confirm.php");
?>

<div class="container">
    <h2>Course: <?php echo $course->fullname ?></h2>
    <div class="btn-group pull-right" role="group">
        <a type="button" class="btn btn-secondary" href="/moodle/koolsoft/course/?action=edit&id=<?php echo $course->id ?>">Edit</a>
        <a type="button" class="btn btn-secondary" data-toggle="modal" data-target="#confirm-delete"
           data-href="/moodle/koolsoft/course/?action=delete&id=<?php echo $course->id ?>">Delete</a>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Lectures</a></li>
        <li><a data-toggle="tab" href="#menu1">Document</a></li>
        <li><a data-toggle="tab" href="#menu2">Posts</a></li>
        <li><a data-toggle="tab" href="#members">Members</a></li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <h4>Lectures</h4>

            <div class="panel-group" id="accordion">
                <?php foreach ($sections as $section) { ?>
                    <?php
                        if($section->section == 0){
                            continue;
                        }
                    ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $section->section ?>">
                                    <?php echo "$section->name ($section->section)"?>
                                </a>
                                <a id="addResource" type="button"  href="<?php echo "/moodle/koolsoft/course/?action=adddata&add=label&idcourse=".$course->id . "&lecture=" . $section->section ?>">Add resource or activity</a>
                            </h4>
                        </div>
                        <div id="<?php echo $section->section ?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <?php
                                    foreach ($section->modinfo->cms as $cms) {
                                        if ($cms->section == $section->id) {
                                            if ($cms->content) {
                                                echo "$cms->content";
                                            }
                                            if ($cms->url) {
                                                echo "<li><a href='$cms->url' > - $cms->name </a> ($cms->section)</li>";
                                            }
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div id="menu1" class="tab-pane fade">
            <h3>Menu 1</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="menu2" class="tab-pane fade">
            <h3>Menu 2</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
        </div>
        <div id="members" class="tab-pane fade">
            <h3>Members</h3>
            <ul class="list-group">
                <?php foreach ($enrolledUsers as $enrolledUser) { ?>

                    <li class="list-group-item">
                        <a href="../../user/profile.php?id=<?php echo $enrolledUser->id ?>"> <?php echo "$enrolledUser->username ($enrolledUser->email)" ?></a>
                    </li>
                <?php } ?>
            </ul>

        </div>
    </div>
</div>
