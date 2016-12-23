
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/froala_editor.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/align.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/char_counter.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/colors.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/emoticons.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/entities.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/file.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/font_family.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/font_size.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/fullscreen.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/image.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/image_manager.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/inline_style.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/line_breaker.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/link.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/quick_insert.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/quote.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/table.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/save.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/url.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/plugins/video.min.js"></script>
<script type="text/javascript" src="/moodle/koolsoft/resources/css/froalaeditor/js/languages/ro.js"></script>

<link rel="stylesheet" href="/moodle/koolsoft/resources/css/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/froala_editor.min.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/froala_style.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/plugins/char_counter.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/plugins/code_view.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/plugins/colors.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/plugins/emoticons.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/plugins/file.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/plugins/fullscreen.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/plugins/image.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/plugins/image_manager.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/plugins/line_breaker.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/plugins/quick_insert.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/plugins/table.css">
<link rel="stylesheet" href="/moodle/koolsoft/resources/css/froalaeditor/css/plugins/video.css">


<div class="container">
    <form action="/moodle/koolsoft/lecture_resource/?action=create" method="POST">
        <div class="form-group">

            <div class="container">
                <div>
                    <textarea id="edit" name="labelContent" required></textarea>
                </div>
            </div>

            <input type="hidden" class="form-control" name="courseId" value="<?php echo $courseId; ?>" >
            <input type="hidden" class="form-control" name="section" value="<?php echo $section; ?>">
            <input type="hidden" class="form-control" name="sectionId" value="<?php echo $sectionId; ?>" >
        </div>
        <button type="submit" class="btn btn-primary pull-right">Submit</button>
    </form>
</div>

<!-- Initialize the editor. -->
<script>
    $(function() {
        $('#edit').froalaEditor()
    });
</script>

