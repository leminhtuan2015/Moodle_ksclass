<?php
    if(!$courses){
        return;

    }
?>

<div style="padding:30px 0px">
    <a style="font-size: 2.0em;" href="" ><i class="fa fa-thumbs-o-up small" style="color:black;width:30px;"></i></a>
    <h4 style="display:inline-block;">Suggestion classes<a href="" style="font-size: 0.8em;"> <u><i>more</i></u></a></h4>
</div>

<div class="" style="width: 100%; overflow: hidden;">
    <?php
    foreach ($courses as $course) {
        if($course->sortorder == 1){ continue;}

        include ("course_overview.php");
    }
    ?>
</div>