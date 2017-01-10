<div class="container" style="width: 50%">

    <form id="createCourseForm" data-toggle="validator" role="form"
          action="<?php echo "$formAction"; ?>" method="post">

        <input type="hidden" name="id" value="<?php echo $course->id ?>">

        <div class="form-group">
            <label for="inputName" class="control-label" >Name</label>
            <input type="text" name="name" class="form-control"
                   id="name" placeholder="Class name" value="<?php echo $course->fullname ?>" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" placeholder="Description" rows="3" name="description"><?php echo $course->summary ?></textarea>
        </div>

        <div class="form-group">
            <label for="inputName" class="control-label">Category</label>
            <select class="form-control" name="categoryId" id="sel2" value="<?php echo $course->category ?>">
                <?php
                foreach ($categoriesName as $key => $categoryName) {
                    if($key == $course->category) {
                        echo "<option selected value='$key'> $categoryName </option>";
                    } else {
                        echo "<option value='$key'> $categoryName </option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Frequency</label>
            <br>
            <label class="radio-inline">
                <input type="radio" name="sequence" value="1" <?php if($course->sequence){ echo "checked";} ?>>Sequence
            </label>
            <label class="radio-inline">
                <input type="radio" name="sequence" value="0" <?php if(!$course->sequence){ echo "checked";} ?>>Random
            </label>
        </div>

        <div class="form-group">
            <label>Privacy</label>
            <br>
            <label class="radio-inline">
                <input type="radio" name="visible" value="1" <?php if($course->visible){ echo "checked";} ?>>Public
            </label>
            <label class="radio-inline">
                <input type="radio" name="visible" value="0" <?php if(!$course->visible){ echo "checked";} ?>>Private
            </label>
        </div>

        <div class="form-group">
            <div class="row">

                <div class='col-sm-6'>
                    <div class="form-group">
                        <label for="inputName" class="control-label">Cost</label>
                        <input type="text" name="cost" class="form-control"
                               id="course_cost" placeholder="0 (vnd)" value="<?php echo $course->cost ?>">
                    </div>
                </div>

                <div class='col-sm-6'>
                    <div class="form-group" id="course_free_type_form_group">
                        <label for="inputName" class="control-label">Lectures Free</label>
                        <div class='input-group col-sm-12'>
                            <select class="form-control" id="course_free_type" name="free_type"
                                    value="<?php echo $course->free_type ?>">
                                <option value='0' <?php if($course->free_type == 0){echo "selected";};?>>No Free</option>
                                <option value='1' <?php if($course->free_type == 1){echo "selected";};?>>1st</option>
                                <option value='2' <?php if($course->free_type == 2){echo "selected";};?>>2nd</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">

                <div class='col-sm-6'>
                    <div class="form-group">
                        <label for="inputName" class="control-label">Start date</label>
                        <div class='input-group date'>
                            <input type='text' class="form-control" placeholder="Start date"
                                   name="startDate" id='startDate' value="<?php echo $course->startdate ?>" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class='col-sm-6'>
                    <div class="form-group">
                        <label for="inputName" class="control-label">End date</label>
                        <div class='input-group date'>
                            <input type='text' class="form-control" placeholder="End date"
                                   name="endDate" id="endDate" value="<?php echo $course->enddate ?>" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <label id="error_date" class="control-label text-danger"</label>
                </div>
            </div>
        </div>

    </form>

    <div class="form-group">
        <button form="createCourseForm" type="submit" class="btn btn-primary">Save</button>
    </div>
</div>


<script src="/moodle/koolsoft/course/resources/course.js"></script>


