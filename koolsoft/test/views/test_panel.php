<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/9/17
 * Time: 11:03 AM
 */
    global $CFG;
    include($CFG->dirroot.'/koolsoft/test/views/templates/test.html');
?>
<div id='testPanel' class='tab-pane fade in'>
    <div id='contentTest' ></div>
</div>

<div class="modal fade" tabindex="-1" id="overTimeDialog" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="header" class="modal-title" id="myModalLabel">Warning</h4>
            </div>

            <div class="modal-body">
                <p id="content"> Timeover! Finish test automatic!</p>
            </div>
        </div>
    </div>
</div>



