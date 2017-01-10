<div id="editLecture<?php echo $sectionEdit->id ?>" class="tab-pane fade">
    <form action="/moodle/koolsoft/lecture/?action=update" method="POST">

        <input type="hidden" class="form-control" name="courseId" value="<?php echo $course->id; ?>" >
        <input type="hidden" class="form-control" name="section" value="<?php echo $sectionEdit->section; ?>">
        <input type="hidden" class="form-control" name="sectionId" value="<?php echo $sectionEdit->id; ?>" >
        <input type="hidden" class="form-control" name="moduleId" value="<?php echo $moduleId; ?>" >

        <h5 class="headerRightPanel">
            <a class='iconPanel' data-toggle="pill">
                <i class="fa fa-angle-left" style="color:white;width:45px;"></i>
            </a>
            <input style="color: #0c0c0c" type="text" name="name" value="<?php echo $sectionEdit->name ?>"/>
            <a class='iconPanel iconRight' style="right:130px;" data-toggle="pill" href="">
                <i class="fa fa-cog" style="color:white;width:45px;"></i>
            </a>
            <button type="submit" class='iconPanel iconRight' style="right:75px;background-color:transparent;border:none">
                <i class="fa fa-floppy-o" style="color:white;width:45px;"></i>
            </button> 
<!--            <button type="submit" class="btn btn-primary">Save</button>-->

            <a class='iconPanel iconRight' style="right:25px;" data-toggle="pill" href="">
                <i class="fa fa-angle-right" style="color:white;width:45px;"></i>
            </a>
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
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],
        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
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