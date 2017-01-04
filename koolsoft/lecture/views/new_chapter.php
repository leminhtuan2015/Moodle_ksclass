<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 1/4/17
 * Time: 2:41 PM
 */

?>

<div class="container">
    <form action="/moodle/koolsoft/lecture/?action=createChapter" method="POST">

        <input type="hidden" class="form-control" name="courseId" value="<?php echo $courseId; ?>" >

        <div class="form-group">
            <label>Name</label>
            <input class="form-control" placeholder="Chapter name" name="name" value="<?php echo $courseSection->name ?>">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
