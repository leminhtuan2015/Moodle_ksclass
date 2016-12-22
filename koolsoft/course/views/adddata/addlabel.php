<html>
<head>

    <!--include font awesome-->
    <link rel="stylesheet" href="../../../resources/css/fontawesome/css/font-awesome.min.css">
    <!--include editor style-->
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/froala_editor.min.css">
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/froala_style.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/plugins/char_counter.css">
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/plugins/code_view.css">
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/plugins/colors.css">
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/plugins/emoticons.css">
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/plugins/file.css">
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/plugins/fullscreen.css">
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/plugins/image.css">
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/plugins/image_manager.css">
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/plugins/line_breaker.css">
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/plugins/quick_insert.css">
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/plugins/table.css">
    <link rel="stylesheet" href="../../../resources/css/froalaeditor/css/plugins/video.css">

    <link rel="stylesheet" href="../../../resources/css/adddata.css">

    <script type="text/javascript">
        function back(id) {
            location.href = "/moodle/koolsoft/course/?action=show&id=" + id;
        }
    </script>

</head>
</html>


<?php

require_once(__DIR__."/../../../shared/header.php");
require_once(__DIR__."/../../../course/models/Label.php");

if(isset($_GET['idcourse'])) {
    $course_id = $_GET['idcourse'];
}
if(isset($_GET['lecture'])) {
    $lecture_id = $_GET['lecture'];
}
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}


if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(!empty($_POST["label"])) {
        $content = $_POST['label'];
        $courseid = $_POST['courseid'];
        $section = $_POST['section'];
        $id = $_POST['id'];
        $label = new Label();
        $label->addData($courseid,$section,$content);
        echo '<script type="text/javascript">
            back('.$id.');
        </script>'
        ;
    }
}
?>


<div id="divForm">
    <form action="addlabel.php" method="POST">
        <div class="form-group">

            <div class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseGeneral">General</a>
                <div id="collapseGeneral" class="panel-collapse collapse in">
                    <p>Label Add</p>
                    <textarea id="edit" name="label"></textarea>
                </div>
            </div>
            <div class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseCommon">Common module setting</a>
                <div id="collapseCommon" class="panel-collapse collapse in">
                    Visible
                    <select class="selectpicker">
                        <option>Show</option>
                        <option>Hide</option>
                    </select>

                </div>
            </div>
            <div class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseRestrict">Restrict access</a>
                <div id="collapseRestrict" class="panel-collapse collapse in">
                    Access restrictions
                    <div id="divAccessRestriction">
                        <p>None</p>
                        <button type="button" class="btn btn-default">Add restriction...</button>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTag">Tag</a>
                <div id="collapseTag" class="panel-collapse collapse in">
                    Tags
                </div>
            </div>
            <div class="panel panel-default">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseCompetencies">Competencies</a>
                <div id="collapseCompetencies" class="panel-collapse collapse in">
                </div>
            </div>
            <input type="hidden" class="form-control" name="courseid" value="<?php echo $course_id;?>" >
            <input type="hidden" class="form-control" name="section" value="<?php echo $lecture_id;?>">
            <input type="hidden" class="form-control" name="id" value="<?php echo $id;?>">
        </div>
        <button type="submit" class="btn btn-default">Add</button>
    </form>
</div>



<!-- Include jQuery. -->
<link rel="stylesheet" href="../../../resources/css/bootstrap.3.3.7.min.css">

<!-- Include JS files. -->
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/froala_editor.min.js"></script>

<!-- Include Code Mirror. -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

<!-- Include Plugins. -->
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/align.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/char_counter.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/colors.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/emoticons.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/entities.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/file.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/font_family.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/font_size.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/fullscreen.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/image.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/image_manager.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/inline_style.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/line_breaker.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/link.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/quick_insert.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/quote.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/table.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/save.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/url.min.js"></script>
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/plugins/video.min.js"></script>

<!-- Include Language file if we want to use it. -->
<script type="text/javascript" src="../../../resources/css/froalaeditor/js/languages/ro.js"></script>

<!-- Initialize the editor. -->
<script>
    $(function() {
        $('#edit').froalaEditor()
    });
</script>


