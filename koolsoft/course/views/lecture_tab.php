<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/29/16
 * Time: 9:38 PM
 */
?>

<script>
    $(document).ready(function()
    {
        var navItems = $('.admin-menu li > a');
        var navListItems = $('.admin-menu li');
        var allWells = $('.admin-content');
        var allWellsExceptFirst = $('.admin-content:not(:first)');

        allWellsExceptFirst.hide();
        navItems.click(function(e)
        {
            e.preventDefault();
            navListItems.removeClass('active');
            $(this).closest('li').addClass('active');

            allWells.hide();
            var target = $(this).attr('data-target-id');
            $('#' + target).show();
        });
    });
</script>


<div class="container">
    <div class="row" style="height: 100%">
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked admin-menu">
                <li class="active"><a href="#" data-target-id="home"><i class="fa fa-home fa-fw"></i> Home</a></li>

                <?php foreach ($sections as $section) { ?>
                    <?php if($section->section == 0){continue;} ?>
                    <li>
                        <a href="" data-target-id="sections<?php echo $section->id ?>">
                            <i class="fa fa-file-o fa-fw"></i>
                            <?php echo "$section->name"?>
                        </a>
                    </li>
                <?php } ?>

            </ul>
        </div>

        <div class="col-md-8 well admin-content" id="home">
            <p>
            <h2>Wellcome to <span class="text-primary"><?php echo $course->fullname ?></span> class</h2>
            </p>
        </div>

        <?php foreach ($sections as $section) { ?>
            <?php if($section->section == 0){continue;} ?>

            <div class="col-md-8 well admin-content" id="sections<?php echo $section->id ?>">
                <?php include (__DIR__."/../../lecture/views/lecture_detail_new.php"); ?>
            </div>

        <?php } ?>
    </div>
</div>