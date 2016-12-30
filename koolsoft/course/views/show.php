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

<style>
    .badge {
        font-size: 12.025px;
        font-weight: bold;
        white-space: nowrap;
        color: grey;
        background-color: #EEEEEE;
        -webkit-border-radius: 9px;
        -moz-border-radius: 9px;
        border-radius: 9px;
    }


</style>

<script>
    new Clipboard('.btn');
</script>

<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });

    $('body').on('click', function (e) {
        //did not click a popover toggle or popover
        if ($(e.target).data('toggle') !== 'popover'
            && $(e.target).parents('.popover.in').length === 0) {
            $('[data-toggle="popover"]').popover('hide');
        }
    });
</script>


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
            <div class="pull-right">
                <div class = "btn-group btn-group-sm">
                    <a type = "button" class = "btn btn-default"
                       href="/moodle/koolsoft/course/?action=edit&id=<?php echo $course->id ?>">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                    </a>

                    <a type = "button" class = "btn btn-default" data-toggle="modal" data-target="#confirm-delete"
                       data-href="/moodle/koolsoft/course/?action=delete&id=<?php echo $course->id ?>">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
                    </a>

                    <?php if($course->isEnroled){ ?>
                        <a type = "button" class = "btn btn-default"
                           href="/moodle/koolsoft/course/?action=unEnrol&id=<?php echo $course->id ?>">
                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Leave
                        </a>
                    <?php } ?>

<!--                    <a type = "button" class = "btn btn-default btn-sm">-->
<!--                        <span class="glyphicon glyphicon-share" aria-hidden="true"></span> Share-->
<!--                    </a>-->


                    <button type="button" class="btn btn-default"
                            data-container="body"
                            data-html="true"
                            data-toggle="popover"
                            data-placement="bottom"
                            title="Share with friends"
                            data-content="
                            <div class='row'>
                                <div class='col-lg-12'>
                                    <div class='input-group'>
                                        <input type='text' id='classLink'
                                               class='form-control' value='<?php echo "localhost/moodle/koolsoft/course/?action=show&id=$course->id"; ?>'>
                                        <span class='input-group-btn'>
                                            <button class='btn btn-default' type='button' data-clipboard-target='#classLink'>
                                                <span class='glyphicon glyphicon-copy' aria-hidden='true'></span> Copy
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class='container'>
                                    <div class='center btn-group' role='group'>
                                        <button type='button' class='btn btn-default'><span class='text-primary'>Facebook</span></button>
                                        <button type='button' class='btn btn-default'><span class='text-primary'>Email</span></button>
                                    </div>
                                </div>
                            </div>">
                        <span class="glyphicon glyphicon-share" aria-hidden="true"></span> Share
                    </button>
                </div>
            </div>

            <h4><a href="/moodle/koolsoft/">Home</a> <span class="text-muted">/</span> <a><?php echo $course->fullname ?></a></h4>

            <div class="tabbable-panel">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#lectures" data-toggle="tab">
                                <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Lectures
                                <span class="badge badge-success small">5</span></a>
                        </li>
                        <li>
                            <a href="#documents" data-toggle="tab">
                                <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Documents
                                <span class="badge">50</span></a>
                        </li>
                        <li>
                            <a href="#discussions" data-toggle="tab">
                                <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Discussions
                                <span class="badge">30</span></a>
                        </li>
                        <li>
                            <a href="#members1" data-toggle="tab">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Members
                                <span class="badge">40</span></a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <div class="pull-right">
                            <div class = "btn-group btn-group-sm">
                                <a type = "button" class = "btn btn-default"
                                   href="/moodle/koolsoft/lecture/?action=new&courseId=<?php echo $course->id ?>&section=&sectionId=">
                                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add lecture
                                </a>
                            </div>
                        </div>
                        <br>
                        <hr>


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

<br>
<br>
<br>

<center>
    <strong>Powered by <a href="minhtuan.techno" target="_blank">LE MINH TUAN</a></strong>
</center>
