<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/21/16
 * Time: 6:16 PM
 */
?>
<div id="questionBankDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Question category</h4>
            </div>
            <div class="modal-body">
                Search question by tag <select multiple="true" style="width: 70%" id="selectTagSearch">

                </select>
                <div style="width: 100%">
                	<ul id="paginationQuestionBank" class="pagination-sm" style="float: right;" ></ul>
                </div>
                <div id="nameQuestions"></div>
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
                <button type="button" class="btn btn-primary" id="btnAddQuestionInBank">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>