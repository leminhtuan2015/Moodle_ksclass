<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/23/16
 * Time: 8:47 AM
 */

?>

<div class="col-sm-14">
    <h2>Class:
        <span class="text-primary">
            <a href="/moodle/koolsoft/course/?action=show&id=<?php echo $course->id ?>">
                <?php echo "$course->fullname - ($section->name)" ?>
            </a>
        </span>
    </h2>

    <div class="btn-group pull-right" role="group">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="/moodle/koolsoft/lecture_resource/?action=new&courseId=<?php echo $course->id ?>&section=<?php echo $section->section ?>&sectionId=<?php echo $section->id; ?>">
                        Add resource
                    </a>
                </li>
                <li>
                    <a href="/moodle/koolsoft/quiz/?action=edit&course=<?php echo $course->id ?>&section=<?php echo $section->id; ?>&lectureId=<?php echo $id; ?>">
                        Add quiz
                    </a>
                    <a href="/moodle/koolsoft/lecture/?action=edit&id=<?php echo $section->id ?>">Edit</a>
                </li>
                <li>
                    <a data-toggle="modal" data-target="#confirm-delete"
                       data-href="/moodle/koolsoft/course/?action=deleteSection&id=<?php echo $section->id ?>">Remove</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#<?php echo $section->id ?>home">Lecture</a></li>
        <li><a data-toggle="tab" href="#<?php echo $section->id ?>menu1">Exercise</a></li>
        <li><a data-toggle="tab" href="#<?php echo $section->id ?>menu2">Discussion</a></li>
    </ul>

    <div class="tab-content">
        <div id="<?php echo $section->id ?>home" class="tab-pane fade in active">
            <div class="panel-group" id="accordion">
                <br>
                <?php
                    foreach ($section->modinfo->cms as $cms) {
                        if ($cms->section == $section->id) {
                            if ($cms->content) {
                                echo "$cms->content";
                            }
                            if ($cms->url) {
                                echo "<li><a href='$cms->url' > - $cms->name </a> ($cms->section)<a href='/moodle/koolsoft/quiz/?action=edit&course=".$courseId."&section=".$section->id."&id=".$cms->instance."' > edit</a></li>";
                            }
                        }
                    }
                ?>
            </div>
        </div>

        <div id="<?php echo $section->id ?>menu1" class="tab-pane fade">
            <h3>Exercise</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="<?php echo $section->id ?>menu2" class="tab-pane fade">
            <br>
            <?php include (__DIR__."/../../shared/views/create_message_box.php"); ?>
        </div>
    </div>
</div>
