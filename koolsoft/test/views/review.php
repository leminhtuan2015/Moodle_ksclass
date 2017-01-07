<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/5/17
 * Time: 9:14 PM
 */

?>

<div class="container">
    <h4>Result quiz : <?php echo $quizName;?></h4>
    <div class="sumary">
        <label>Started on : <?php echo $summarydata["startedon"]["content"]; ?></label><br>
        <label>State : <?php echo $summarydata["state"]["content"]; ?></label><br>
        <label>Completed on : <?php echo $summarydata["completedon"]["content"]; ?></label><br>
        <label>Time taken : <?php echo $summarydata["timetaken"]["content"]; ?></label><br>
        <label>Grade : <?php echo $summarydata["grade"]["content"]; ?></label><br>
    </div>
    <a href="/moodle/koolsoft/course/?action=show&id=<?php echo $courseId;?>">Return to course</a>
</div>
