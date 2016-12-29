<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:04 PM
 */

require_once(__DIR__."/../../shared/views/confirm.php");

?>

<link rel="stylesheet" href="/moodle/koolsoft/course/resources/course.css" />

<div class="container">
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
</div>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4><a><?php echo $course->fullname ?></a></h4>

            <div class="tabbable-panel">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#lectures" data-toggle="tab">Lectures</a>
                        </li>
                        <li>
                            <a href="#documents" data-toggle="tab">Documents</a>
                        </li>
                        <li>
                            <a href="#discussions" data-toggle="tab">Discussions</a>
                        </li>
                        <li>
                            <a href="#members1" data-toggle="tab">Members</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="lectures">
                            <?php require ("lecture_tab.php")?>
                        </div>
                        <div class="tab-pane" id="documents">
                            DOCUMENTS
                        </div>
                        <div class="tab-pane" id="discussions">
                            DISCUSSIONS
                        </div>
                        <div class="tab-pane" id="members1">
                            MEMBERS
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<center>
    <strong>Powered by <a href="minhtuan.techno" target="_blank">LE MINH TUAN</a></strong>
</center>