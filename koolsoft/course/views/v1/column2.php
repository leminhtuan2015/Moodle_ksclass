<div class="tab-content listCategory" style="overflow:scroll; overflow-x: hidden;">
    <div>
        <h5 class="titleCourse textOverflow" style="padding: 5px 5px 7px 5px;color:white;display: inline-block;">
            <a <?php if($course->isOwner) { ?> href="/moodle/koolsoft/course/?action=edit&id=<?php echo $course->id ?>" <?php } ?>
               style="color: whitesmoke;padding-left: 5px;">
                <?php echo $course->fullname ?>
            </a>
        </h5>
        <?php if($course->isOwner) { ?>
	        <div class="dropdown" style="display: inline-block;float: right; margin-top: 5px;">
	            <a class="dropdown-toggle iconPanel" data-toggle="dropdown">
	                <img src="../resources/images/add-01.png" class="iconHome">
	            </a>
	            <ul class="dropdown-menu menuCustom">
	                <li><a href='#' data-toggle='modal' data-target='#createChapter'>Create Chapter</a></li>
	                <li><a href='#' data-toggle='modal' data-target='#createLecture'>Create lecture</a></li>
	                <li><a data-toggle='modal' class='createQuizBtn'>Create quiz</a></li>
	            </ul>
	        </div>
        <?php } ?>
    </div>

    <div id="Home" class="tab-pane fade in active">
        <div class="panel-group white_color">

            <?php foreach ($sections as $sectionChapter) { ?>
                <?php if($sectionChapter->section == 0){continue;} ?>

                <?php if($sectionChapter->parent_id == 0){ ?>
                    <div>
                        <h5 class="panel-title chapterName textOverflow" style="padding-left:10px;vertical-align:middle;">
                            <a data-toggle="collapse" data-parent="#chapter<?php echo $sectionChapter->id?>"
                               href="#collapse_chapter<?php echo $sectionChapter->id?>">
                                <?php echo "$sectionChapter->name"?>
                            </a>
                        </h5>
                        <h6 style="display:inline-block;vertical-align:middle;">7/12</h6>
                        <img src="../resources/images/more-01.png" width="10px" style="display:inline-block;vertical-align:middle;margin-left:3px">
                    </div>

                    <div id="collapse_chapter<?php echo $sectionChapter->id?>" class="panel-collapse collapse in">
                        <?php include ("chapter.php");?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

