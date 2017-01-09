<div id="members" class="tab-pane fade in">

    <?php
        if(!$enrolledUsers){
            echo "This class have no members.";
            echo "</div>";
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
