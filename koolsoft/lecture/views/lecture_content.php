<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/26/16
 * Time: 9:24 AM
 */

?>

<div class="btn-group pull-right" role="group">
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </button>
        <ul class="dropdown-menu">
            <li>
                <a href="/moodle/koolsoft/lecture_resource/?action=new&courseId=<?php echo $course->id ?>&section=<?php echo $section->section ?>&sectionId=<?php echo $section->id; ?>">
                    Add Lecture
                </a>
            </li>

            <li>
                <a href="/moodle/koolsoft/lecture_resource/?action=edit&courseId=<?php echo $course->id ?>&section=<?php echo $section->section ?>&sectionId=<?php echo $section->id; ?>&moduleId=<?php echo $cm->id; ?>">
                    Edit Lecture
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

<div>
    <?php
        if ($cm->content) {
            echo "$cm->content ($cm->id)";
        }
    ?>
</div>



