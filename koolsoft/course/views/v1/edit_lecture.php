<div id="editLecture<?php echo $sectionEdit->id ?>" class="tab-pane fade">
    <form action="/moodle/koolsoft/lecture/?action=update" method="POST">

        <input type="hidden" class="form-control" name="courseId" value="<?php echo $course->id; ?>" >
        <input type="hidden" class="form-control" name="section" value="<?php echo $sectionEdit->section; ?>">
        <input type="hidden" class="form-control" name="sectionId" value="<?php echo $sectionEdit->id; ?>" >
        <input type="hidden" class="form-control" name="moduleId" value="<?php echo $moduleId; ?>" >

        <h5 class="headerRightPanel">
            <div style="display: inline-block; width: 85%; text-align: center;">
                <img src="/moodle/koolsoft/resources/images/previous-black-01.png" style="width:30px;margin-right:20px;vertical-align:middle;"></img>
                    <input style="color: #0c0c0c;width: 50%;padding:5px;" type="text" name="name" value="<?php echo $sectionEdit->name ?>"/>
                <img src="/moodle/koolsoft/resources/images/next-black-01.png" style="width:30px;margin-left:20px;vertical-align:middle;right:110px;"></img>
            </div>
            <div style="display: inline-block; float:right">
                <img src="/moodle/koolsoft/resources/images/setting-01.png" style="width:30px;margin-right:10px;vertical-align:middle;"></img>
                <button type="submit" style="right:75px;background-color:transparent;border:none">
                   <img src="/moodle/koolsoft/resources/images/save-01.png" style="width:25px;margin-right:10px;vertical-align:middle;"></img>
                </button> 
            <div>

        </h5>
        <div>
            <textarea id="textEditor<?php echo $sectionEdit->id ?>" name="labelContent"></textarea>
        </div>
    </form>
</div>

<script>
    function tinymceInitDoneCallback<?php echo $sectionEdit->id ?>(inst){

    <?php if($labelContent){ ?>

        <?php $labelContent = str_replace(array("\r", "\n"), '', $labelContent); ?>
        <?php $labelContent = str_replace('"', '\"', $labelContent); ?>

            var content = "<?php echo $labelContent ?>"

            tinymce.activeEditor.setContent(content);
        <?php } ?>
    }

</script>

<script>
    tinymce.init({
        selector: '#textEditor<?php echo $sectionEdit->id ?>',
        init_instance_callback: "tinymceInitDoneCallback<?php echo $sectionEdit->id ?>",
        height: 500,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc',
            'iframe imageupload'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample imageupload',
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