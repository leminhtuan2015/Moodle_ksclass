<div class="panel-group" >

    <?php foreach ($sections as $sectionLecture) { ?>
        <?php if($sectionLecture->parent_id == $sectionChapter->id){ ?>
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="#lecture<?php echo $sectionLecture->id ?>" class="btHTML" data-toggle="pill">
                        <?php echo $sectionLecture->name ?>
                    </a>
                    <br>
                    <?php
                        foreach ($sectionLecture->modinfo->cms as $cm) {
                            if ($cm->section == $sectionLecture->id) {
                                if($cm->module == ClientUtil::$resourceTypeQuiz){
                                    echo "<a class='btHTML' href='/moodle/koolsoft/test/?cmid=".$cm->id."' >".$cm->name."</a> <br>";
                                }
                            }
                        }
                    ?>
                </h4>
            </div>

        <?php } ?>
    <?php } ?>
</div>