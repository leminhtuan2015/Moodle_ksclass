<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/26/16
 * Time: 9:24 AM
 */

?>
<br>
<div class="btn-group pull-right" role="group" style="margin-top: -80px">
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </button>
        <ul class="dropdown-menu">
            <li>
                <a href="/moodle/koolsoft/lecture/?action=edit&courseId=<?php echo $course->id ?>&section=<?php echo $section->section ?>&sectionId=<?php echo $section->id; ?>&moduleId=<?php echo $cm->id; ?>">
                    Edit
                </a>
            </li>
            <li>
                <a data-toggle="modal" data-target="#confirm-delete"
                   data-href="/moodle/koolsoft/lecture/?action=delete&id=<?php echo $section->id ?>">Delete</a>
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



