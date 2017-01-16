<li class="comment">
    <a class="pull-left" href="#">
        <img class="avatar" src="http://bootdey.com/img/Content/user_3.jpg" alt="avatar">
    </a>
    <div class="comment-body">
        <div class="comment-heading">
            <h4 class="user"><?php echo $post_child->firstname ?></h4>
            <h5 class="time"><?php echo $post_child->post_time_human ?></h5>
        </div>
        <p><?php echo $post_child->message ?></p>
    </div>
</li>