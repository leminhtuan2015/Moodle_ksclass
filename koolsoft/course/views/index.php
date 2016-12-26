<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:04 PM
 */


?>

<div class="container">
        <div class="">
            <table class="table table-hover">
                <thead>
                <tr>
                    <td>Name</td>
                    <td>Last modified</td>
                    <td>Enrol status</td>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($courses as $course) { ?>

                    <?php if($course->sortorder == 1){ continue;}?>

                    <tr style="height: 50px">
                        <td>
                            <a href='/moodle/koolsoft/course/?action=show&id=<?php echo $course->id; ?>'>
                                <?php echo $course->fullname; ?>
                            </a>
                            <br>
                            <p class='small'>Create by: <cite><a href="#">Owner</a></cite></p>
                        </td>
                        <td>
                            <p class='small'>2016/11/12</p>
                        </td>
                        <td>
                            <?php if(CourseUtil::isEnrolled($course->id)){ ?>
                                <a type="button" href="/moodle/koolsoft/course/?action=unEnrol&id=<?php echo "$course->id"?>" class="btn btn-warning">Leave</a>
                            <?php } else if(CourseUtil::isFree($course->id)) { ?>
                                <a type="button" href="/moodle/koolsoft/course/?action=selfEnrol&id=<?php echo "$course->id"?>" class="btn btn-primary">Join (Free)</a>
                            <?php } else { ?>
                                <button type="button" class="btn btn-primary">Buy (99$)</button>
                            <?php } ?>

                        </td>
                    </tr>

                <?php } ?>
                </tbody>
            </table>
        </div>
</div>
