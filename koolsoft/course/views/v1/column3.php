<div class="rightPanel tab-content" style="overflow:scroll; overflow-x: hidden;">
<!--    RENDER LECTURE CONTENT-->

    <script src="/moodle/koolsoft/test/resources/javascript/test.js"></script>
    <script src="/moodle/koolsoft/exercise/resources/javascript/exercise.js"></script>
    <link rel="stylesheet" href="/moodle/koolsoft/exercise/resources/css/exercise.css" />
    <link rel="stylesheet" href="/moodle/koolsoft/test/resources/css/test.css" />

    <?php foreach ($sections as $section) { ?>
        <?php if($section->section == 0 || $section->parent_id == 0){continue;} ?>

        <div id="lecture<?php echo $section->id ?>" class="tab-pane fade in <?php if($lectureActive && $lectureActive == $section->id){ echo "active"; }?>">
            <h4 class="headerRightPanel">
                <a class='iconPanel' data-toggle="pill" style="vertical-align:middle;padding-top:3px;">
                    <i class="fa fa-angle-left" style="color:white;width:45px;"></i>
                </a>
                <?php echo $section->name ?>
                <a class='iconPanel iconRight' style="right:110px;margin-top:3px;" data-toggle="pill" href="">
                    <i class="fa fa-cog" style="color:white;width:45px;"></i>
                </a>

                <a class='iconPanel iconRight' style="right:55px;margin-top:3px;" data-toggle="pill" href="#editLecture<?php echo $section->id ?>">
                    <i class="fa fa-pencil-square-o" style="color:white;width:45px;"></i></a>

                <a class='iconPanel iconRight' style="right:5px;" data-toggle="pill" href="">
                    <i class="fa fa-angle-right" style="color:white;width:45px;"></i></a>
            </h4>

            <!-- RENDER LABEL CONTENT -->
            <div>
                <?php
                    foreach ($section->modinfo->cms as $cm) {
                        if ($cm->section == $section->id) {
                            if($cm->module == ClientUtil::$resourceTypeLable){
                                echo "<div style='margin-left: 20px'>$cm->content</div>";
                            }
                        }
                    }
                ?>
            </div>
        </div>

        <!-- RENDER TÉT-->
        <?php
           include (__DIR__."/../../../test/views/test_panel.php");
           include (__DIR__."/../../../exercise/views/exercise_panel.php");
        ?>

    <?php } ?>

    <!--    RENDER EDIT LECTURE FORM-->
    <?php
        foreach ($sections as $sectionEdit) {
            if($sectionEdit->section == 0 || $sectionEdit->parent_id == 0){continue;}

            $labelContent = "";
            $moduleId = "";

            foreach ($sectionEdit->modinfo->cms as $cm) {
                if ($cm->module == ClientUtil::$resourceTypeLable && $cm->section == $sectionEdit->id) {
                    $moduleId = $cm->id;

                    if($cm->content){
                        $labelContent = "$cm->content";
                    }
                }
            }

            include ("edit_lecture.php");
        }
    ?>

    <!--    RENDER MEMBER TAB-->
    <?php require_once ("members.php")?>

    <?php require_once (__DIR__."/../../../discussion/views/index.php");?>
</div>