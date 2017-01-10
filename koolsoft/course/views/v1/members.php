<div id="members" class="tab-pane fade in">

    <?php
        if(!$enrolledUsers){
            echo "This class have no members.";
            echo "</div>";
            return;
        }

        require_once (__DIR__."/../../../quiz/views/quiz_result_for_user.php");
    ?>

    <div class="container">
        <h2>Members</h2>
        <table class="table" >
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Progess</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($enrolledUsers as $member) {?>
                <tr>
                    <td><?php echo "$member->firstname"?></td>
                    <td><?php echo "$member->email"?></td>
                    <td><button id-user="<?php echo $member->id;?>" name-user="<?php echo $member->firstname;?>" id-course="<?php echo $course->id;?>" class="btn btn-primary showQuizResultUser"> Progess</button></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>
