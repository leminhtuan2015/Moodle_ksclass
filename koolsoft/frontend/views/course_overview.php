<style>
    .rcorners {
        border-radius: 10px;
        border: 1px solid;
        padding-top: 5px;
        margin-left: 20px;
        width: 200px;
        height: 150px;
    }

    .truncate {
        width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<a href="/moodle/koolsoft/course/?action=show&id=<?php echo $course->id ?>">
    <div class="rcorners col-sm-6">
        <div class="truncate"> Class: <b><?php echo $course->fullname ?></b></div>
        <div>Description: </div>
        <div>Complete: </div>
        <div>Members: </div>
        <div>Payment:
            <?php
                if($course->isFree) {
                    echo "<span class='text-success'>Free</span>";
                } else {
                    echo "<span class='text-danger'>Paid</span>";
                }?>
        </div>
    </div>
</a>

