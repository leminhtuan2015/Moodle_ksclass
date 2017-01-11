<div class="panel-group" >

    <?php foreach ($sections as $sectionLecture) { ?>
        <?php if($sectionLecture->parent_id == $sectionChapter->id){ ?>
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="#lecture<?php echo $sectionLecture->id ?>" class="btHTML lectureTitle" data-toggle="pill">
                        <?php echo $sectionLecture->name ?>
                    </a>
                    <br>
                    <?php foreach ($sectionLecture->modinfo->cms as $cm) { ?>
                        <?php if ($cm->section == $sectionLecture->id) { ?>
                            <?php if($cm->module == ClientUtil::$resourceTypeQuiz){ ?>
                                <a data-toggle='pill' class='showQuizBtn btnQuiz' id-quiz-instance='<?php echo $cm->instance ?>' id-section='<?php echo $cm->section ?>' id-quiz='<?php echo $cm->id ?>' href='#quiz<?php echo $cm->id ?>' > <?php echo $cm->name ?></a>
                                <br>

                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                </h4>
            </div>

        <?php } ?>
    <?php } ?>
</div>