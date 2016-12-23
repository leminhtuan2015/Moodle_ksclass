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
                <h4 class="modal-title">Question bank</h4>
            </div>
            <div class="modal-body">
                <p>Select question in question bank</p>
                <?php echo \html_writer::select($catmenu, 'category', null, array(), array('class' => 'searchoptions custom-select', 'id' => 'id_selectacategory')); ?>
                <div id="nameQuestions"></div>
<!--                <form id="addQuestionForm" method="post" action="?action=addQuestion">-->
<!--                    <input style="display: none" id="idQuestions" name="idQuestions">-->
<!--                </form>-->
                <table class='table' style="width: 100%">
                    <thead>
                        <tr>
                            <th><input type='checkbox' value='' id='idCheckBoxAll' idQuestion='' nameQuestion=''></th>
                            <th>Question</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTableQuestionBank">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button submit" class="btn btn-danger" id="btnAddQuestionInBank">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>