<style>
    .status-upload form {
        float: left;
        width: 100%;
    }
    .status-upload form textarea {
        background: none repeat scroll 0 0 #fff;
        border: medium none;
        -webkit-border-radius: 4px 4px 0 0;
        -moz-border-radius: 4px 4px 0 0;
        -ms-border-radius: 4px 4px 0 0;
        -o-border-radius: 4px 4px 0 0;
        border-radius: 4px 4px 0 0;
        color: #777777;
        float: left;
        font-size: 14px;
        height: 100px;
        letter-spacing: 0.3px;
        padding: 20px;
        width: 100%;
        resize:vertical;
        outline:none;
        border: 1px solid #F2F2F2;
    }

    .status-upload ul {
        float: left;
        list-style: none outside none;
        margin: 0;
        padding: 0 0 0 15px;
        width: auto;
    }
    .status-upload ul > li {
        float: left;
    }
    .status-upload ul > li > a {
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        color: #777777;
        float: left;
        font-size: 14px;
        height: 30px;
        line-height: 30px;
        margin: 10px 0 10px 10px;
        text-align: center;
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -ms-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
        width: 30px;
        cursor: pointer;
    }
    .status-upload ul > li > a:hover {
        background: none repeat scroll 0 0 #606060;
        color: #fff;
    }
    .status-upload form button {
        border: medium none;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        color: #fff;
        float: right;
        font-size: 14px;
        letter-spacing: 0.3px;
        margin-right: 9px;
        margin-top: 9px;
        padding: 6px 15px;
    }
    .dropdown > a > span.green:before {
        border-left-color: #2dcb73;
    }
    .status-upload form button > i {
        margin-right: 7px;
    }
</style>

<script>
    tinymce.init({
        selector: '#newPostForm',
        height: 120,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
        image_advtab: true,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });
</script>

<div>
    <form action="/moodle/koolsoft/discussion/?action=create" method="post" id="new_discussion_form">
        <input type="hidden" name="forum" id="new_discussion_form_forum" value="<?php echo $forumId ?>"/>
        <input type="hidden" name="courseId" id="new_discussion_form_courseId" value="<?php echo $course->id ?>"/>

        <textarea id="newPostForm" name="message" placeholder="What are you doing right now?"></textarea>
        <br>
            <button type="submit" class="btn btn-primary pull-right">Post</button>
        <br>
        <br>
    </form>
</div><!-- Status Upload  -->

<script>
    // SUBMIT FORM BY AJAX
    $(function () {
        $("#new_discussion_form").on('submit', function (e) {
            e.preventDefault();

            forumId = $("#new_discussion_form_forum").val()
            courseId = $("#new_discussion_form_courseId").val()
            discussionMessage = $("#newPostForm").val()

//            alert(forumId + courseId + discussionMessage)

            data = {"forum" : forumId, "courseId": courseId, "message": discussionMessage};

            $.ajax({
                type: 'post',
                url: '/moodle/koolsoft/discussion/index.php/?action=create',
                data: data,
                success: function (result) {
//                    alert(result)
                    if(result){
                        $("#list_discussion_of_course").prepend(result)
                        $("#newPostForm").empty()
                    }
                }
            });
        });
    });
</script>













