<div class="panel panel-white post panel-shadow">
    <div class="post-heading">
        <div class="pull-left image">
            <img src="/moodle/koolsoft/resources/images/default-avatar.png" class="avatar" alt="user profile image" style="width:50px;height:50px;">
        </div>
        <div class="pull-left meta">
            <div class="title h5">
                <a href="#"><b><?php echo $discussion->post->firstname?></b></a>
            </div>
            <h6 class="text-muted time time_ago_of_discussion"><?php echo $discussion->time_ago ?></h6>
        </div>
    </div>
    <div class="post-description">
        <p>
            <?php echo $discussion->post->message ?>
        </p>
        <div class="stats">
<!--            <a href="#" class="btn btn-default stat-item">-->
<!--                <i class="fa fa-thumbs-up icon"></i>0-->
<!--            </a>-->
            Reply (<span id="reply_count_<?php echo $discussion->id ?>"><?php echo $discussion->replycount ?></span>)

        </div>
    </div>
    <?php include ("replies.php")?>
</div>