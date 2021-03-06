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

$context = context_COURSE::instance($course->id);
$enrolledUsers = get_enrolled_users($context, 'mod/assignment:submit');

?>

<div class="col-sm-14">
    <h2>Class:
        <span class="text-primary">
            <a href="/moodle/koolsoft/course/?action=show&id=<?php echo $course->id ?>">
                <?php echo $course->fullname ?>
            </a>
        </span>

        <div class="btn-group pull-right" role="group">
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="/moodle/koolsoft/course/?action=edit&id=<?php echo $course->id ?>">Edit</a></li>
                    <li><a data-toggle="modal" data-target="#confirm-delete"
                           data-href="/moodle/koolsoft/course/?action=delete&id=<?php echo $course->id ?>">Delete</a></li>
                </ul>
            </div>
        </div>
    </h2>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#<?php echo $course->id ?>lectures">Lectures</a></li>
        <li><a data-toggle="tab" href="#<?php echo $course->id ?>document">Document</a></li>
        <li><a data-toggle="tab" href="#<?php echo $course->id ?>posts">Posts</a></li>
        <li><a data-toggle="tab" href="#<?php echo $course->id ?>members">Members</a></li>
    </ul>

    <div class="tab-content">
        <div id="<?php echo $course->id ?>lectures" class="tab-pane fade in active">

            <div class="btn-group pull-right" role="group" style="margin-top: 20px">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/moodle/koolsoft/lecture/?action=new&courseId=<?php echo $course->id ?>&section=<?php echo $section->section ?>&sectionId=<?php echo $section->id; ?>">
                                Add Lecture
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

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
                                    <p class='small'>Create by: <cite><a href="#">Owner</a></cite></p>
                                </td>
                                <td>
                                    <p class='small'>2016/11/12</p>
                                </td>
                                <td>
                                    <button class='btn btn-danger pull-right btn-xs' data-toggle="modal" data-target="#confirm-delete"
                                       data-href="/moodle/koolsoft/lecture/?action=delete&id=<?php echo $section->id ?>">
                                        <span class="glyphicon glyphicon-remove pull-right" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="<?php echo $course->id ?>document" class="tab-pane fade">
            <h3>Document</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="<?php echo $course->id ?>posts" class="tab-pane fade">
            <br>
            <?php include (__DIR__."/../../shared/views/create_message_box.php"); ?>
        </div>
        <div id="<?php echo $course->id ?>members" class="tab-pane fade">
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
                                <p class='small'>progress</p>
                            </td>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>