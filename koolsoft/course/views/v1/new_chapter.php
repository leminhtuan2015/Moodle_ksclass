<div class="modal fade" id="createChapter" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New chapter</h4>
            </div>
                <div class="modal-body">
                    <form id="newChapterForm" action="/moodle/koolsoft/lecture/?action=createChapter" method="POST">
                    <input type="hidden" class="form-control" name="courseId" value="<?php echo $course->id; ?>" >

                    <div class="form-group">
                        <div id="chapterInputs">
                            <input placeholder="Chapter name" name="name[]">
                        </div>
                        <br>
                        <span class="btn btn-default pull-left" id="addChapterBtn">Add</span>
                        <br>

                    </div>

                    </form>
                </div>
                <div class="modal-footer">

                    <button type="submit" form="newChapterForm" class="btn btn-primary" >Save</button>
                </div>

        </div>
    </div>
</div>

<script>
    $( "#addChapterBtn" ).click(function() {
        addInput("chapterInputs", "Chapter name")
    })
</script>