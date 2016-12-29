<style>
    .rcorners {
        border-radius: 10px;
        border: 1px solid;
        padding-top: 5px;
        margin-left: 20px;
        margin-top: 20px;
        width: 200px;
        height: 150px;
    }

    .truncate {
        width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    a.disable {
        color: gray;
    }

    a.out_of_date {
        color: red;
    }

</style>

<a href="/moodle/koolsoft/course/?action=show&id=<?php echo $course->id ?>"
   class="<?php if(!$course->visible){echo "disable";} else if(!$course->isPresent){ echo "out_of_date"; }?>">
    <div class="rcorners col-sm-6">
        <div class="truncate"> Class: <b><?php echo $course->fullname ?></b></div>
        <div>Description: <?php echo $course->startdate ?></div>
        <div>Complete: </div>
        <div>Members: </div>
        <div>Payment:
            <?php
                if($course->isFree) {
                    echo "<span class='text-success'>Free</span>";
                } else {
                    echo "<span class='text-danger'>99$</span>";
                }?>
        </div>
    </div>
</a>


