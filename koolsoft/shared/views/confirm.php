<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/20/16
 * Time: 4:07 PM
 */

?>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>

            <div class="modal-body">
                <p>You are about to delete one item?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
        console.log("1111111111");
        console.log($(e.relatedTarget).data('href'));
        console.log($(e.relatedTarget));
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
</script>

<!--<a href="#" data-href="/delete.php?id=23" data-toggle="modal" data-target="#confirm-delete">Delete record #23</a><br>-->
<!---->
<!--<button class="btn btn-default" data-href="/delete.php?id=54" data-toggle="modal" data-target="#confirm-delete">-->
<!--    Delete record #54-->
<!--</button>-->
