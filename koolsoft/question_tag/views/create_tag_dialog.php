<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/21/16
 * Time: 6:16 PM
 */
?>
<div id="createTagDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="createTagDialogHeader">Create new tag</h4>
            </div>
            <div class="modal-body">
                <div style="display: none" class="form-group">
                    <label for="tagId">Tag id:</label>
                    <input class="form-control" id="tagId">
                </div>
                <div class="form-group">
                    <label for="tagName">Tag name:</label>
                    <input class="form-control" id="tagName">
                </div>
                <div class="form-group">
                    <label style="display: none; color: #ff5f50;" id="createTagErrorText"></label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button submit" class="btn btn-danger" id="btnAddTag">Add</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>