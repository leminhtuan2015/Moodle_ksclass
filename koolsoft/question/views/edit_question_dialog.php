<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/21/16
 * Time: 6:16 PM
 */
?>
<style>

</style>

<div id="editQuestionDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="">Edit questions</h4>
            </div>
            <div class="modal-body">
                    <div id="questionDiv">
                        <div class="form-group" style="display: none;">
                            <label for="questionEditTxt">Id</label>
                            <input class="form-control" placeholder="question" id="questionEditId">
                        </div>
                        <div class="form-group">
                            <label for="questionEditTxt">Question</label>
                            <input class="form-control" placeholder="question" id="questionEditTxt">
                        </div>
                        <div class="form-group">
                            <label for="answerEditTxt">Answer</label>
                            <input class="form-control" placeholder="answer" id="answerEditTxt">
                        </div>
                        <div class="form-group">
                            <label for="wrongAnserEditTxt0">Wrong Answer</label>
                            <input class="form-control" placeholder="wrong answer" id="wrongAnserEditTxt0">
                        </div>
                        <div class="form-group">
                            <label for="wrongAnserEditTxt1">Wrong Answer</label>
                            <input class="form-control" placeholder="wrong answer" id="wrongAnserEditTxt1">
                        </div>
                        <div class="form-group">
                            <label for="wrongAnserEditTxt2">Wrong Answer</label>
                            <input class="form-control" placeholder="wrong answer" id="wrongAnserEditTxt2">
                        </div>
                        <div class="form-group">
                            <label for="selectTagEditQuestion">Tags</label>
                            <select multiple="true" style="width: 100%" id="selectTagEditQuestion"> </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="display: none; color: #ff5f50;" id="editQuestionErrorText"></label>
                    </div>
                    <br>
            </div>
            <div class="modal-footer">
                <button type="button submit" class="btn btn-primary" id="saveEditQuestion">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>