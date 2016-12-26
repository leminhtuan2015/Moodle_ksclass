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
                    foreach ($section->modinfo->cms as $cm) {
                        if ($cm->section == $section->id) {
                            include (__DIR__."/lecture_content.php");
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
