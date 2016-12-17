<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:04 PM
 */



?>

<div class="container">
    <div class="panel panel-primary" style="width: 960px">
        <div class="panel-heading">
            <h3 class="panel-title pull-left">Classes</h3>

<!--            <button class="btn btn-default pull-right">New</button>-->
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
