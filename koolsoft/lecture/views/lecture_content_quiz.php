<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/26/16
 * Time: 9:24 AM
 */

?>

<div  style="float: left; width: 100%;">
    <div style="display: inline-block" >Quiz : <?php echo $cm->name ?></div>
    <div style="display: inline-block;float: right;" class="dropdown" >
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="glyphicon glyphicon-cog"  aria-hidden="true"></span>
        </button>
        <ul class="dropdown-menu">
            <li>
                <a href="/moodle/koolsoft/quiz/?action=edit&course=<?php echo $course->id ?>&section=<?php echo $section->section ?> &lectureId=<?php echo $section->id ?>&id=<?php echo $cm->instance ?>">Edit quiz</a>
            </li>
            <li>
                <a data-toggle="modal" data-target="#confirm-delete"">Delete</a>
            </li>
        </ul>
    </div>
</div>

<div>
    <?php
        if(!$section->visible){
            echo "This lecture is not visible: <a href='#'>Pay</a>";
        } else {
            if ($cm->content) {
                echo "$cm->content";
//                echo "($cm->id)";
            }
        }
    ?>
</div>

<br>
<br>



