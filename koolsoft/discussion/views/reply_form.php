<div class="input-group">
    <input class="form-control" placeholder="Write a comment..." type="text"
           id="reply_discussion_input_<?php echo $discussion->firstpost ?>"
           firstpostId="<?php echo $discussion->firstpost ?>">
    <span class="input-group-addon">
            <a href="#"><i class="fa fa-edit"></i></a>
        </span>
</div>

<script>
    $("#reply_discussion_input_<?php echo $discussion->firstpost ?>").on("keypress", function (e) {
        if (e.keyCode == 13) {
            replyId = $(this).attr("firstpostId")
            replyMessage = $(this).val()

            if(replyMessage == ""){
                return
            }

            $.post({
                url: "/moodle/koolsoft/discussion/index.php?action=createReply",
                data : {"replyId": replyId, "replyMessage": replyMessage},
                success: function(result){
//                    alert(result)
                    if(result){
                        $("#reply_list_" + replyId).prepend(result);
                        $("#reply_discussion_input_" + replyId).val("")

                        oldReplyCount = $("#reply_count_<?php echo $discussion->id ?>").html()
                        newReplyCount = parseInt(oldReplyCount) + 1
                        $("#reply_count_<?php echo $discussion->id ?>").html(newReplyCount)
                    } else {
                        alert("Somethings wrong. Please try again.")
                    }
                }
            });
        }
    });
</script>