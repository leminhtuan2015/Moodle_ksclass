<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/9/17
 * Time: 11:03 AM
 */
    global $CFG;
    include('templates/exercise.html');
?>
<div id='exercisePanel' class='tab-pane fade in'>
    <div id='contentExercise' ></div>
</div>

<div class="modal fade" tabindex="-1" id="exerciseProgressDialog" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="header" class="modal-title" id="myModalLabel">Progress</h4>
            </div>

            <div class="modal-body">
                <div id="content">

                </div>
            </div>
        </div>
    </div>
</div>

