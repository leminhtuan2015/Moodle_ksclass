<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/21/16
 * Time: 6:16 PM
 */
?>
<style>
    h1 {
        margin-left: 15px;
        margin-bottom: 20px;
    }

</style>

<div id="addToQuizDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add question to quiz</h4>
            </div>
            <div class="modal-body">
                <label>Quiz list</label>
                <table class='table' style="width: 100%">
                    <thead>
                    <tr>
                        <th class="col-md-1"><input type='checkbox' value='' id='idCheckBoxQuestionBankAll' idQuestion='' nameQuestion=''></th>
                        <th class="col-md-11">Question</th>
                    </tr>
                    </thead>
                    <tbody id="bodyTableQuestionBank">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button submit" class="btn btn-primary" id="addToQuizBtn">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>