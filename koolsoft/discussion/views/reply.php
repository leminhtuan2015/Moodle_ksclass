<li class="comment">
    <a class="pull-left" href="#">
        <img class="avatar" src="/moodle/koolsoft/resources/images/user_3.jpg" alt="avatar">
    </a>
    <div class="comment-body">
        <div class="comment-heading">
            <h4 class="user" style="display:inline-block;"><?php echo $post_child->firstname ?></h4>
            <p style="display:inline-block;margin-bottom:5px;" ><?php echo $post_child->message ?></p>
        </div>
        <h6 class="time" id="time_ago_of_reply_discussion_<?php echo $post_child->id ?>" style="margin:5px 0px;">
                <?php echo $post_child->time_ago ?>
        </h6>
    </div>
</li>

<script>
    timeAgoMinutes_<?php echo $post_child->id ?> = 0

    setInterval(timeAgoTimerHandle_<?php echo $post_child->id ?>, 5000);

    function timeAgoTimerHandle_<?php echo $post_child->id ?>() {
        timeAgo = $("#time_ago_of_reply_discussion_<?php echo $post_child->id ?>").html();

//        console.log(timeAgoMinutes_<?php //echo $post_child->id ?>//)
        if(timeAgo.includes("minute")){
            timeAgoMinutes_<?php echo $post_child->id ?> ++

            console.log(timeAgoMinutes_<?php echo $post_child->id ?>)

            time = timeAgo.trim().split(" ")[0]
            time = parseInt(time)

            if(timeAgoMinutes_<?php echo $post_child->id ?> == 12){
                if(time < 59){
                    timeAgoMinutes_<?php echo $post_child->id ?> = 0
                    time = time + 1
                    $("#time_ago_of_reply_discussion_<?php echo $post_child->id ?>").empty()
                    $("#time_ago_of_reply_discussion_<?php echo $post_child->id ?>").html(time + " minutes ago")
                } else {
                    $("#time_ago_of_reply_discussion_<?php echo $post_child->id ?>").empty()
                    $("#time_ago_of_reply_discussion_<?php echo $post_child->id ?>").html(1 + " hours ago")
                }

            }
        } else if(timeAgo.includes("just now")){
            $("#time_ago_of_reply_discussion_<?php echo $post_child->id ?>").empty()
            $("#time_ago_of_reply_discussion_<?php echo $post_child->id ?>").html(5 + " seconds ago")

        } else if(timeAgo.includes("seconds")){
            time = timeAgo.trim().split(" ")[0]
            time = parseInt(time)

            if(time < 55){
                timeAgoMinutes_<?php echo $post_child->id ?> = 0
                time = time + 5
                $("#time_ago_of_reply_discussion_<?php echo $post_child->id ?>").empty()
                $("#time_ago_of_reply_discussion_<?php echo $post_child->id ?>").html(time + " seconds ago")
            } else {
                $("#time_ago_of_reply_discussion_<?php echo $post_child->id ?>").empty()
                $("#time_ago_of_reply_discussion_<?php echo $post_child->id ?>").html(1 + " minute ago")
            }
        }
    }
</script>