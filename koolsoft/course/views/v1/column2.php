<div class="tab-content listCategory" style="overflow:scroll; overflow-x: hidden;">
    <div style="border-bottom: 2px solid #797979;">
        <h4 style="padding: 5px 5px 7px 5px;color:white;display: inline-block">
            <a class="titleCourse"
               href="/moodle/koolsoft/course/?action=edit&id=<?php echo $course->id ?>"
               style="color: whitesmoke">
                <?php echo $course->fullname ?>
            </a>
        </h4>
        <a type="button" class="btn btn-primary" style="display: inline-block;float: right; margin-top: 10px;"
           data-container="body"
           data-html="true"
           data-toggle="popover"
           data-placement="bottom"
           title="Setting"
           data-content="">
            <i class="fa fa-plus-circle" style="color:white;"></i>
        </a>
    </div>

<!--    <ul class='dropdown-menu menuCustom'>-->
<!--        <h5 style='text-align: center; font-weight: bold;'>-->
<!--            New contents-->
<!--        </h5>-->
<!--        <h5 style='text-align: center;'>-->
<!--            <a data-toggle='modal' data-target='#createChapter'>Create Chapter</a>-->
<!--        </h5>-->
<!--        <h5 style='text-align: center;'>-->
<!--            <a data-toggle='modal' data-target='#createLecture'>Create lecture</a>-->
<!--        </h5>-->
<!--        <h5 style='text-align: center;'>-->
<!--            <a data-toggle='modal' class='createQuizBtn'>Create quiz</a>-->
<!--        </h5>-->
<!--    </ul>-->




<!--    <div class="dropdown" style="padding-bottom: 30px;">-->
<!--        <a class='iconPanel dropdown-toggle' data-toggle="dropdown" style="float:right;">-->
<!--            <i class="fa fa-plus-circle" style="color:white;"></i>-->
<!--        </a>-->
<!--        <ul class="dropdown-menu menuCustom">-->
<!--            <h5 style="text-align: center; font-weight: bold;">-->
<!--                New contents-->
<!--            </h5>-->
<!--            <h5 style="text-align: center;">-->
<!--                <a data-toggle="modal" data-target="#createChapter">Create Chapter</a>-->
<!--            </h5>-->
<!--            <h5 style="text-align: center;">-->
<!--                <a data-toggle="modal" data-target="#createLecture">Create lecture</a>-->
<!--            </h5>-->
<!--            <h5 style="text-align: center;">-->
<!--                <a data-toggle="modal" class="createQuizBtn">Create quiz</a>-->
<!--            </h5>-->
<!--        </ul>-->
<!--    </div>-->

    <div id="Home" class="tab-pane fade in active">
        <div class="panel-group white_color">

            <?php foreach ($sections as $sectionChapter) { ?>
                <?php if($sectionChapter->section == 0){continue;} ?>

                <?php if($sectionChapter->parent_id == 0){ ?>
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#chapter<?php echo $sectionChapter->id?>"
                               href="#collapse_chapter<?php echo $sectionChapter->id?>">
                                <?php echo "$sectionChapter->name"?>
                            </a>
                        </h4>
                    </div>

                    <div id="collapse_chapter<?php echo $sectionChapter->id?>" class="panel-collapse collapse in">
                        <?php include ("chapter.php");?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

