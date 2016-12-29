<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:04 PM
 */

require_once(__DIR__."/../../shared/views/confirm.php");

?>


<style>
    h1 {
        margin-left: 15px;
        margin-bottom: 20px;
    }

    @media (min-width: 768px) {

        .brand-pills > li > a {
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;
        }
    }

    /* make sidebar nav vertical */
    @media (min-width: 768px) {
        .sidebar-nav .navbar .navbar-collapse {
            padding: 0;
            max-height: none;
        }
        .sidebar-nav .navbar ul {
            float: none;
            display: block;
        }
        .sidebar-nav .navbar li {
            float: none;
            display: block;
        }
        .sidebar-nav .navbar li a {
            padding-top: 12px;
            padding-bottom: 12px;
        }
    }

</style>

<div class="container">
    <div class="row">
        <div role="tabpanel">

            <div class="col-xs-2">
                <div class="sidebar-nav">
                    <div class="navbar navbar-default" role="navigation">
                        <div class="navbar-collapse collapse sidebar-navbar-collapse">
                            <ul class="nav navbar-nav">

                                <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">

                                    <li role="presentation" class="brand-nav">
                                        <a href="#post" aria-controls="tab4" role="tab" data-toggle="tab">Posts</a>
                                    </li>
                                    <li role="presentation" class="brand-nav">
                                        <a href="#document" aria-controls="tab4" role="tab" data-toggle="tab">Document</a>
                                    </li>
                                    <li role="presentation" class="brand-nav">
                                        <a href="#members" aria-controls="tab4" role="tab" data-toggle="tab">Members</a>
                                    </li>

                                    <li role="presentation" class="brand-nav">
                                        <a href="/moodle/koolsoft/course/?action=edit&id=<?php echo $course->id ?>">Edit</a>
                                    </li>

                                    <li role="presentation" class="brand-nav">
                                        <a href="/moodle/koolsoft/course/?action=unEnrol&id=<?php echo $course->id ?>">Leave</a>
                                    </li>

                                </ul>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </div>

            <div class="col-xs-2">
                <div class="sidebar-nav">
                    <div class="navbar navbar-default" role="navigation">
                        <div class="navbar-collapse collapse sidebar-navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="#"><b><?php echo "$course->fullname" ?></b></a></li>

                                <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">
                                    <?php $hightlight = true; ?>
                                    <?php foreach ($sections as $section) { ?>
                                        <?php if($section->section == 0){continue;} ?>

                                        <li role="presentation" class="brand-nav <?php if($hightlight){ echo "active"; $hightlight = false;}?>">
                                            <a href="#section<?php echo $section->id ?>" aria-controls="tab4" role="tab" data-toggle="tab"><?php echo "$section->name"?></a>
                                        </li>
                                    <?php } ?>

                                    <li role="presentation" class="brand-nav">
                                        <a href="/moodle/koolsoft/lecture/?action=new&courseId=<?php echo $course->id ?>&section=&sectionId=">Add lecture</a>
                                    </li>
                                </ul>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="post">
                        <?php require_once (__DIR__."/../../shared/views/create_message_box.php");?>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="document">
                        <div>DOCUMENTS</div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="members">
                        <div>MEMBERS</div>
                    </div>

                    <?php $hightlight = true; ?>
                    <?php foreach ($sections as $section) { ?>
                        <?php if($section->section == 0){continue;} ?>

                        <div role="tabpanel" class="tab-pane <?php if($hightlight){ echo "active"; $hightlight = false;}?>"
                             id="section<?php echo $section->id ?>">
                            <?php include (__DIR__."/../../lecture/views/lecture_detail_new.php"); ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>


