<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/23/16
 * Time: 8:47 AM
 */

?>

<div class="col-sm-14">
    <h2>Course: <?php echo "$course->fullname ($section->name)" ?></h2>
    <div class="btn-group pull-right" role="group">
        <a type="button" class="btn btn-secondary" href="/moodle/koolsoft/lecture/?action=edit&id=<?php echo $section->id ?>">Edit</a>
        <a type="button" class='btn btn-secondary' data-toggle="modal" data-target="#confirm-delete"
           data-href="/moodle/koolsoft/course/?action=deleteSection&id=<?php echo $section->id ?>">Remove</a>
        <a id="addResource" type="button" class="btn btn-secondary"
           onclick="functionAddResource(<?php echo $section->section?>)"> Add resource
        </a>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#<?php echo $section->id ?>home">Lectures</a></li>
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
                                echo "<li><a href='$cms->url' > - $cms->name </a> ($cms->section)</li>";
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
            <h3>Discussion</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
        </div>
    </div>
</div>
