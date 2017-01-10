<div class="panel-group" >

    <?php foreach ($sections as $sectionLecture) { ?>
        <?php if($sectionLecture->parent_id == $sectionChapter->id){ ?>
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="#lecture<?php echo $sectionLecture->id ?>" class="btHTML" data-toggle="pill">
                        <?php echo $sectionLecture->name ?>
                    </a>
                    <br>
                    <?php foreach ($sectionLecture->modinfo->cms as $cm) { ?>
                        <?php if ($cm->section == $sectionLecture->id) { ?>
                            <?php if($cm->module == ClientUtil::$resourceTypeQuiz){ ?>
                                    <div class='dropdown btHTML' >
                                        <label><?php echo $cm->name ?></label>
                                        <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>
                                            <span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
                                        </button>
                                        <ul class='dropdown-menu'>
                                            <li><a data-toggle='pill' class='showQuizBtn btHTML' id-quiz='<?php echo $cm->id ?>' href='#quiz<?php echo $cm->id ?>' > Play</a>  </li>;
                                            <li class='editQuizBtn' id-section='<?php echo $cm->section ?>' id-quiz='<?php echo $cm->instance ?>'> <a >Edit</a></li>";
                                        </ul>
                                    </div>
                                    <br>

                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                </h4>
            </div>

        <?php } ?>
    <?php } ?>
</div>