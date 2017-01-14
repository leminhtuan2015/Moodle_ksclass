<div class="panel-group" >

    <?php foreach ($sections as $sectionLecture) { ?>
        <?php if($sectionLecture->parent_id == $sectionChapter->id){ ?>
            <div>
                <h4 class="panel-title">
                    <div class="active_link_lecture textOverflow" 
                         style="padding:16px;cursor: pointer;" 
                         id="lecture_<?php echo $sectionLecture->id ?>" >
                        <img src="../resources/images/round-01.png" width="8px">
                        <span href="#lecture<?php echo $sectionLecture->id ?>" 
                            class="lectureTitle " data-toggle="pill" style="padding-left:5px;font-size: 0.9em;">
                            <?php echo $sectionLecture->name ?>
                        </span>
                    </div>

                    <?php foreach ($sectionLecture->modinfo->cms as $cm) { ?>
                        <?php if ($cm->section == $sectionLecture->id) { ?>
                            <?php if($cm->module == ClientUtil::$resourceTypeQuiz){?>
                                <?php $quiz = $quizs[$cm->instance];?>
                                <?php if($quiz->type == ClientUtil::$typeTest){ ?>
                                    <div style="padding:10px;color:white;margin-left:25px;cursor: pointer;" 
                                        class="active_link_lecture_test textOverflow"
                                        parent-id="<?php echo $sectionLecture->id ?>">
                                        <img src="../resources/images/test-01.png" width="10px" style="margin-left: 5px;">
                                        <span  data-toggle='pill' class='showQuizBtn btnExercise ' 
                                            id-quiz-instance='<?php echo $cm->instance ?>' 
                                            id-section='<?php echo $cm->section ?>'
                                            id-quiz='<?php echo $cm->id ?>' 
                                            href='#quiz<?php echo $cm->id ?>' > 
                                            <?php echo $cm->name ?>
                                        </span>
                                        <br>
                                    </div>
                                <?php }else { ?>
                                    <div style="padding:10px;color:white;margin-left:25px;cursor: pointer;"
                                         class="active_link_lecture_test textOverflow" 
                                         parent-id="<?php echo $sectionLecture->id ?>">
                                        <img src="../resources/images/star-01.png" width="10px" style="margin-left: 5px;">
                                        <span data-toggle='pill' class='showExerciseBtn btnExercise' 
                                           id-quiz-instance='<?php echo $cm->instance ?>' 
                                           id-section='<?php echo $cm->section ?>'
                                           id-quiz='<?php echo $cm->id ?>' href='#exercise<?php echo $cm->id ?>' >
                                           <?php echo $cm->name ?>
                                       </span>
                                        <br>
                                    </div>
                                <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                </h4>
            </div>

        <?php } ?>
    <?php } ?>
</div>

