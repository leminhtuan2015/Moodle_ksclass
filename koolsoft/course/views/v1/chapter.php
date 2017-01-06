<div class="panel-group" >

    <?php foreach ($sections as $sectionLecture) { ?>
        <?php if($sectionLecture->parent_id == $sectionChapter->id){ ?>
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a href="#lecture<?php echo $sectionLecture->id ?>" class="btHTML" data-toggle="pill">
                        <?php echo $sectionLecture->name ?>
                    </a>
                    <br>
                </h4>
            </div>

        <?php } ?>
    <?php } ?>
</div>