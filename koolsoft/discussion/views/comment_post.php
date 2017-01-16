<div class="post-footer">
    <div class="input-group">
        <input class="form-control" placeholder="Add a comment" type="text"
               id="reply_discussion_input_<?php echo $discussion->firstpost ?>"
               firstpostId="<?php echo $discussion->firstpost ?>">
        <span class="input-group-addon">
            <a href="#"><i class="fa fa-edit"></i></a>
        </span>
    </div>

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

<script>
  $("#reply_discussion_input_<?php echo $discussion->firstpost ?>").on("keypress", function (e) {
      if (e.keyCode == 13) {
          replyId = $(this).attr("firstpostId")
          replyMessage = $(this).val()

          $.post({
              url: "/moodle/koolsoft/discussion/index.php?action=createReply",
              data : {"replyId": replyId, "replyMessage": replyMessage},
              success: function(result){
//                    alert(result)
                  if(result){
                      $("#reply_list_" + replyId).prepend(result);
                      $("#reply_discussion_input_" + replyId).val("")
                  }
              }
          });
      }
  });
</script>