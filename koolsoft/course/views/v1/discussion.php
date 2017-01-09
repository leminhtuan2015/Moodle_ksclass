<style>

    body{
        background:#eee;
    }

    hr {
        margin-top: 20px;
        margin-bottom: 20px;
        border: 0;
        border-top: 1px solid #FFFFFF;
    }
    a {
        color: #82b440;
        text-decoration: none;
    }
    .blog-comment::before,
    .blog-comment::after,
    .blog-comment-form::before,
    .blog-comment-form::after{
        content: "";
        display: table;
        clear: both;
    }

    .blog-comment{
        padding-left: 15%;
        padding-right: 15%;
    }

    .blog-comment ul{
        list-style-type: none;
        padding: 0;
    }

    .blog-comment img{
        opacity: 1;
        filter: Alpha(opacity=100);
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
    }

    .blog-comment img.avatar {
        position: relative;
        float: left;
        margin-left: 0;
        margin-top: 0;
        width: 65px;
        height: 65px;
    }

    .blog-comment .post-comments{
        border: 1px solid #eee;
        margin-bottom: 20px;
        margin-left: 85px;
        margin-right: 0px;
        padding: 10px 20px;
        position: relative;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        background: #fff;
        color: #6b6e80;
        position: relative;
    }

    .blog-comment .meta {
        font-size: 13px;
        color: #aaaaaa;
        padding-bottom: 8px;
        margin-bottom: 10px !important;
        border-bottom: 1px solid #eee;
    }

    .blog-comment ul.comments ul{
        list-style-type: none;
        padding: 0;
        margin-left: 85px;
    }

    .blog-comment-form{
        padding-left: 15%;
        padding-right: 15%;
        padding-top: 40px;
    }

    .blog-comment h3,
    .blog-comment-form h3{
        margin-bottom: 40px;
        font-size: 26px;
        line-height: 30px;
        font-weight: 800;
    }
</style>

<div id="discussionBox" class="tab-pane fade in">
<div class="bootstrap snippet">
    <div class="row">
        <div class="col-md-12">
            <div class="blog-comment">
                <h3 class="text-success">Comments</h3>
                <hr/>

                <ul class="comments">

                    <?php foreach ($discussions as $discussion) { ?>
                        <li class="clearfix">
                            <img src="http://bootdey.com/img/Content/user_1.jpg" class="avatar" alt="">
                            <div class="post-comments">
                                <p class="meta">Dec 18, 2014 <a href="#">JohnDoe</a> says : <i class="pull-right"><a href="#"><small>Reply</small></a></i></p>
                                <p>
                                    <?php echo $discussion->name ?> (<?php echo $discussion->post->message ?>)
                                </p>
                            </div>
                        </li>
                    <?php } ?>


<!--                    <li class="clearfix">-->
<!--                        <img src="http://bootdey.com/img/Content/user_2.jpg" class="avatar" alt="">-->
<!--                        <div class="post-comments">-->
<!--                            <p class="meta">Dec 19, 2014 <a href="#">JohnDoe</a> says : <i class="pull-right"><a href="#"><small>Reply</small></a></i></p>-->
<!--                            <p>-->
<!--                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.-->
<!--                                Etiam a sapien odio, sit amet-->
<!--                            </p>-->
<!--                        </div>-->
<!--                        <ul class="comments">-->
<!--                            <li class="clearfix">-->
<!--                                <img src="http://bootdey.com/img/Content/user_3.jpg" class="avatar" alt="">-->
<!--                                <div class="post-comments">-->
<!--                                    <p class="meta">Dec 20, 2014 <a href="#">JohnDoe</a> says : <i class="pull-right"><a href="#"><small>Reply</small></a></i></p>-->
<!--                                    <p>-->
<!--                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.-->
<!--                                        Etiam a sapien odio, sit amet-->
<!--                                    </p>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                        </ul>-->
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>