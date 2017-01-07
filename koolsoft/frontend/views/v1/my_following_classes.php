<?php
    if(!$myFollowingCourses){
        return;

    }
?>

<div style="padding:30px 0px;">
    <a class='iconFont-Home' href="" ><i class="fa fa-star-o small" style="color:black;width:30px;"></i></a>
    <h4 style="display:inline-block;">My Following classes<a href="" style="font-size: 0.8em;"> <u><i>more</i></u></a></h4>
</div>

<div class="" style="width: 100%; overflow: hidden;">
    <?php
    foreach ($myFollowingCourses as $course) {
        include ("course_overview.php");
    }
    ?>
</div>