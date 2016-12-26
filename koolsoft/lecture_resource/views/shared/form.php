<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/25/16
 * Time: 12:14 PM
 */
?>

<head>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

    <script>
        function tinymceInitDoneCallback(inst){
            <?php if($labelContent){ ?>
                var content = '<?php echo $labelContent ?>';
                tinymce.activeEditor.setContent(content);
            <?php } ?>
        }
    </script>

    <script>
        tinymce.init({
            selector: '#textEditor',
            init_instance_callback: "tinymceInitDoneCallback",
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
</head>


<div class="container">
    <form action="<?php echo $formAction; ?>" method="POST">
        <div class="form-group">

            <div class="container">
                <div>
                    <textarea id="textEditor" name="labelContent"></textarea>
                </div>
            </div>

            <input type="hidden" class="form-control" name="courseId" value="<?php echo $courseId; ?>" >
            <input type="hidden" class="form-control" name="section" value="<?php echo $section; ?>">
            <input type="hidden" class="form-control" name="sectionId" value="<?php echo $sectionId; ?>" >
            <input type="hidden" class="form-control" name="moduleId" value="<?php echo $moduleId; ?>" >
        </div>
        <button type="submit" class="btn btn-primary pull-right">Submit</button>
    </form>
</div>