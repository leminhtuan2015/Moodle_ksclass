<div class="modal fade" id="createChapter" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New chapter</h4>
            </div>
            <div class="modal-body">

                <form action="/moodle/koolsoft/lecture/?action=createChapter" method="POST">

                    <input type="hidden" class="form-control" name="courseId" value="<?php echo $course->id; ?>" >

                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" placeholder="Chapter name" name="name" ">
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>