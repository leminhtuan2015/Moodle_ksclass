<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/20/16
 * Time: 1:29 PM
 */

?>

<div class="container">
    <div class="panel panel-primary" style="width: 960px">
        <div class="panel-heading">
            <h3 class="panel-title pull-left">Courses</h3>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body center">
            <!-- List group -->
            <ul class="list-group">

                <?php foreach ($courses as $c) { ?>
                    <li class="list-group-item"><?php echo "<a href='../course/?action=show&id=$c->id'>$c->fullname</a>" ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
