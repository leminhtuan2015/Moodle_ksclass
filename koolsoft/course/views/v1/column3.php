<div class="rightPanel tab-content" style="overflow:scroll; overflow-x: hidden;">

    <?php foreach ($sections as $section) { ?>
        <?php if($section->section == 0 || $section->parent_id == 0){continue;} ?>

        <div id="lecture<?php echo $section->id ?>" class="tab-pane fade in">
            <h4 class="headerRightPanel">
                <a class='iconPanel' data-toggle="pill">
                    <i class="fa fa-angle-left" style="color:white;width:45px;"></i>
                </a>
                <?php echo $section->name ?>
                <a class='iconPanel iconRight' style="right:110px;" data-toggle="pill" href="">
                    <i class="fa fa-cog" style="color:white;width:45px;"></i>
                </a>

                <a class='iconPanel iconRight' style="right:55px;" data-toggle="pill" href="#editLecture<?php echo $section->id ?>">
                    <i class="fa fa-pencil-square-o" style="color:white;width:45px;"></i></a>

                <a class='iconPanel iconRight' style="right:5px;" data-toggle="pill" href="">
                    <i class="fa fa-angle-right" style="color:white;width:45px;"></i></a>
            </h4>
            <div>
                <?php
                    foreach ($section->modinfo->cms as $cm) {
                        if ($cm->section == $section->id) {
                            if($cm->module == ClientUtil::$resourceTypeQuiz){
    //                            include (__DIR__."/lecture_content_quiz.php");
                            }else if($cm->module == ClientUtil::$resourceTypeLable){
                                echo "$cm->content";
                            }
                        }
                    }
                ?>
            </div>
        </div>

    <?php } ?>

    <?php
        foreach ($sections as $sectionEdit) {
            if($sectionEdit->section == 0 || $sectionEdit->parent_id == 0){continue;}

            $labelContent = "";
            $moduleId = "";

            foreach ($sectionEdit->modinfo->cms as $cm) {
                if ($cm->section == $sectionEdit->id) {
                    $moduleId = $cm->id;

                    if($cm->content){
                        $labelContent = "$cm->content";
                    }
                }
            }

//            Logger::log("xxxx".$labelContent);

            include ("edit_lecture.php");
        }
    ?>
</div>
