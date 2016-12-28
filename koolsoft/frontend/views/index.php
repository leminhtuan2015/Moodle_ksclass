<?php
?>

<style>
    .marginTop {
        margin-top: 40px;
    }

</style>


<div class="container">
    <h4 class="marginTop">Favorist's classes</h4>
    <hr>
    <div class="container">
        <div class="row">
            <?php
                foreach ($myCourses as $course) {
                    include ("course_overview.php");
                }
            ?>
        </div>
    </div>

    <h4 class="marginTop">All classes</h4>
    <hr>
    <div class="container">
        <div class="row">

            <?php
                foreach ($courses as $course) {
                    if($course->sortorder == 1){ continue;}

                    include ("course_overview.php");
                }
            ?>
        </div>
    </div>

    <h4 class="marginTop">Recomment classes</h4>
    <hr>
    <div class="container">
        <div class="row">
            <?php
                foreach ($recommentCourses as $course) {
                    $borderColor = "";

                    if($course->isFree){
                        $borderColor = "#2196F3";
                    } else {
                        $borderColor = "#F44336";
                    }

                    include ("course_overview.php");
                }
            ?>
        </div>
    </div>

</div>