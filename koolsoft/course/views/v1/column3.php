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
                <div style="display: inline-block; width: 85%; text-align: center;">
                    <img src="/moodle/koolsoft/resources/images/previous-black-01.png" style="width:30px;margin-right:20px;vertical-align:middle;"></img>
                        <?php echo $section->name ?>
                    <img src="/moodle/koolsoft/resources/images/next-black-01.png" style="width:30px;margin-left:20px;vertical-align:middle;right:110px;"></img>
                </div>
                <div style="display: inline-block; float:right">
                    <img src="/moodle/koolsoft/resources/images/setting-01.png" style="width:30px;margin-right:10px;vertical-align:middle;"></img>
                    <a style="right:55px;margin-top:3px;" data-toggle="pill" href="#editLecture<?php echo $section->id ?>">
                        <img src="/moodle/koolsoft/resources/images/edit-01.png" style="width:30px;margin-right:10px;vertical-align:middle;"></img>
                    </a>
                <div>
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

    <div id="course_file" class="tab-pane fade in">
        <?php require_once (__DIR__."/../../../file/views/index.php");?>
    </div>
</div>