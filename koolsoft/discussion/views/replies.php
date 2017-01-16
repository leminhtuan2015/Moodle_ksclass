<div class="post-footer">
    <?php include "reply_form.php";?>

    <ul class="comments-list">
        <li class="comment">
            <ul class="comments-list" id="reply_list_<?php echo $discussion->firstpost ?>">

                <?php foreach ($discussion->children as $post_child) { ?>
                    <?include "reply.php"?>
                <?php } ?>
            </ul>
        </li>
    </ul>
</div>