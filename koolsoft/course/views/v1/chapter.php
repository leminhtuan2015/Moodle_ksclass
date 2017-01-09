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
                                    $html =" <div class='dropdown btHTML' >";
                                    $html .= "<label>".$cm->name."</label>";
                                    $html .= "<button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>";
                                    $html .= "<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>";
                                    $html .= "</button>";
                                    $html .= "<ul class='dropdown-menu'>";
                                    $html .= "<li>"."<a data-toggle='pill' class='showQuizBtn btHTML' id-quiz='".$cm->id."' href='#quiz".$cm->id."' > Play</a> "." </li>";
                                    $html .= "<li class='editQuizBtn' id-section='".$cm->section."' id-quiz='".$cm->instance."'> <a >Edit</a></li>";
                                    $html .= "</ul> </div> <br>";
                                    echo $html;
                                }
                            }
                        }
                    ?>
                </h4>
            </div>

        <?php } ?>
    <?php } ?>
</div>