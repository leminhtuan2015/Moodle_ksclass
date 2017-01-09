<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 1/9/17
 * Time: 3:02 PM
 */



?>

<div id="members" class="tab-pane fade in">
    <?php
        if(!$enrolledUsers){
            echo "This class have no members.";
            return;
        }
    ?>

    <div class="container">
        <h2>Members</h2>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($enrolledUsers as $member) {?>
                <tr>
                    <td><?php echo "$member->firstname"?></td>
                    <td><?php echo "$member->email"?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>
