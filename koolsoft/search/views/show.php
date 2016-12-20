<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/20/16
 * Time: 11:31 AM
 */

if(!$courses){
    echo "<div class='container'><h3>No Course Found</h3></div>";
    return;
}

?>


<div class="container">
    <div class="panel panel-primary" style="width: 960px">
        <div class="panel-heading">
            <h3 class="panel-title pull-left">Search result</h3>
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