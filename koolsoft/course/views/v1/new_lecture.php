<div class="modal fade" id="createLecture" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New lecture</h4>
            </div>
            <div class="modal-body">

                <div class="container">
                    <form action="/moodle/koolsoft/lecture/?action=create" method="POST">
                        <input type="hidden" class="form-control" name="courseId" value="<?php echo $course->id; ?>" >

                        <div class="form-group">
                            <div class="form-group" id="course_free_type_form_group">
                                <label for="inputName" class="control-label">Chapter</label>
                                <div class='input-group col-sm-4'>
                                    <select class="form-control" name="parent_id">
                                        <?php foreach ($chapters as $chapter){ ?>
                                            <option value="<?php echo $chapter->id ?>" <?php if($chapter->id == $courseSection->parent_id){echo "selected";};?>><?php echo $chapter->name ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group col-sm-4">
                                <label>Name</label>
                                <input class="form-control" placeholder="Lecture name" name="name">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group col-sm-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>