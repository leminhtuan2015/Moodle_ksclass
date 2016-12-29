<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/23/16
 * Time: 8:47 AM
 */

?>

<div class="col-sm-14">
    <h2>
        <span class="text-primary">
            <?php echo "$section->name" ?>
        </span>
    </h2>

    <?php if(!$course->isEnroled){ ?>
        <?php if($course->isFree){ ?>
            <div class="alert alert-success">
                <a href="/moodle/koolsoft/course/?action=selfEnrol&id=<?php echo $course->id ?>" class="alert-link">Join this class</a>.
            </div>
        <?php } else { ?>
            <div class="alert alert-warning">
                <a href="#" class="alert-link">Pay this class</a>.
            </div>
        <?php } ?>
    <?php } ?>

    <hr>
    <div class="tab-content">
        <div id="<?php echo $section->id ?>lecture" class="tab-pane fade in active">
            <div class="panel-group" id="accordion">
                <?php
                    foreach ($section->modinfo->cms as $cm) {
                        if ($cm->section == $section->id) {
                            include (__DIR__."/lecture_content.php");
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>
