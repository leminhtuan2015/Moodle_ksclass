<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/22/16
 * Time: 9:30 AM
 */
global $CFG;

require_once(__DIR__."/../../shared/views/confirm.php");
require_once(__DIR__."/../../../config.php");
require_once($CFG->dirroot. '/course/lib.php');
require_once($CFG->libdir. '/coursecatlib.php');

$modinfo = get_fast_modinfo($course);
$modnames = get_module_types_names();
$modnamesplural = get_module_types_names(true);
$modnamesused = $modinfo->get_used_module_names();
$mods = $modinfo->get_cms();
$sections = $modinfo->get_section_info_all();

//$context = context_COURSE::instance($course->id);
//$enrolledUsers = get_enrolled_users($context, 'mod/assignment:submit');
//$enrolledUsers = $this->enrolledUsers($course->id);

?>

<div class="col-sm-14">
    <h2>Course: <?php echo $course->fullname ?></h2>
    <div class="btn-group pull-right" role="group">
        <a type="button" class="btn btn-secondary" href="/moodle/koolsoft/course/?action=edit&id=<?php echo $course->id ?>">Edit</a>
        <a type="button" class="btn btn-secondary" data-toggle="modal" data-target="#confirm-delete"
           data-href="/moodle/koolsoft/course/?action=delete&id=<?php echo $course->id ?>">Delete</a>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#<?php echo $course->id ?>home">Lectures</a></li>
        <li><a data-toggle="tab" href="#<?php echo $course->id ?>menu1">Document</a></li>
        <li><a data-toggle="tab" href="#<?php echo $course->id ?>menu2">Posts</a></li>
        <li><a data-toggle="tab" href="#<?php echo $course->id ?>members">Members</a></li>
    </ul>

    <div class="tab-content">
        <div id="<?php echo $course->id ?>home" class="tab-pane fade in active">
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
                                <a href="/moodle/koolsoft/lecture/?action=show&id=<?php echo $section->id ?>&courseId=<?php echo $course->id ?>">
                                    <?php echo "$section->name ($section->section)"?>
                                </a>
                            </h4>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div id="<?php echo $course->id ?>menu1" class="tab-pane fade">
            <h3>Document</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="<?php echo $course->id ?>menu2" class="tab-pane fade">
            <h3>Posts</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
        </div>
        <div id="<?php echo $course->id ?>members" class="tab-pane fade">
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