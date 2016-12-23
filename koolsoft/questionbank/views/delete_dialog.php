<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/21/16
 * Time: 6:16 PM
 */
?>
<div id="deleteQuestionDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirm</h4>
            </div>
            <div class="modal-body">
                <p>Are you absolutely sure you want to delete the following questions?</p>
                <div id="nameQuestions"></div>
<!--                <form id="deleteQuestionForm" method="post" action="?action=show&courseid=--><?php //echo $courseid?><!--&cat=--><?php //echo $cat?><!--">-->
                    <input style="display: none" id="idQuestions" name="idQuestions">
                    <span id="nameQuestions"></span>
                    <input style="display: none" name="idDelete" value="true">
<!--                </form>-->
            </div>
            <div class="modal-footer">
                <button type="button submit" class="btn btn-danger" id="deleteQuestionBtn">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>