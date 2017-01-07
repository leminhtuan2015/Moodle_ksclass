<?php
    if(!$myCreatedCourses){
        return;

    }
?>

<div style="padding:30px 0px" style="margin-top:10px;">
    <a style="font-size: 2.0em;" href="" ><i class="fa fa-user small" style="color:black;width:30px;"></i></a>
    <h4 style="display:inline-block;">My own classes<a href="" style="font-size: 0.8em;"> <u><i>more</i></u></a></h4>
</div>

<div class="" style="width: 100%; overflow: hidden;">
    <?php
    foreach ($myCreatedCourses as $course) {
        include ("course_overview.php");
    }
    ?>
</div>