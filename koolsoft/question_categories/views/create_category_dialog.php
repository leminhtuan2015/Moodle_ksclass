<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/21/16
 * Time: 6:16 PM
 */
?>
<div id="createCategoryDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="createCategoryDialogHeader">Create new topic</h4>
            </div>
            <div class="modal-body">
                <div style="display: none" class="form-group">
                    <label for="name">Topic id:</label>
                    <input class="form-control" id="categoryId">
                </div>
                <div class="form-group">
                    <label for="name">Topic name:</label>
                    <input class="form-control" id="categoryName">
                </div>
                <div class="form-group">
                    <label for="infor">Topic infor:</label>
                    <input class="form-control" id="categoryInfor">
                </div>
                <div class="form-group">
                    <label style="display: none; color: #ff5f50;" id="createCategoryErrorText"></label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button submit" class="btn btn-danger" id="btnAddCategory">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>