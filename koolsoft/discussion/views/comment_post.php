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
            <ul class="comments-list">

                <?php foreach ($discussion->children as $post_child) { ?>
                    <li class="comment">
                        <a class="pull-left" href="#">
                            <img class="avatar" src="http://bootdey.com/img/Content/user_3.jpg" alt="avatar">
                        </a>
                        <div class="comment-body">
                            <div class="comment-heading">
                                <h4 class="user"><?php echo $post_child->firstname ?></h4>
                                <h5 class="time">3 minutes ago</h5>
                            </div>
                            <p><?php echo $post_child->message ?></p>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </li>
    </ul>
</div>

<script>
  $("#reply_discussion_input_<?php echo $discussion->firstpost ?>").on("keypress", function (e) {
      if (e.keyCode == 13) {
          reply = $(this).attr("firstpostId")
          alert(reply)

          $.post({url: "/moodle/koolsoft/discussion/index.php?action=createReply"
              , data : {"reply": reply}
              , success: function(result){
                alert("okie")
              }
          });
      }
  });
</script>