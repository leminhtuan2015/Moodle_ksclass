<div id="files_container">
    <?php foreach ($files as $file) {?>
        <?php include ("file_item.php")?>
    <?php }?>
</div>


<!-- Modal -->
<div class="modal fade" id="file_info" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">File URL</h4>
            </div>
            <div class="modal-body">
                <input class="form-control" id="file_url_info" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>