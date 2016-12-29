<div class="container">

    <form id="createCourseForm" data-toggle="validator" role="form"
          action="<?php echo "$formAction"; ?>" method="post">

        <input type="hidden" name="id" value="<?php echo $course->id ?>">

        <div class="form-group">
            <label for="inputName" class="control-label" >Name</label>
            <input type="text" name="name" class="form-control"
                   id="inputName" placeholder="Class name" value="<?php echo $course->fullname ?>" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" placeholder="Description" rows="3" name="description"><?php echo $courseSection->summary ?></textarea>
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
            <label>Payment</label>
            <br>
            <label class="radio-inline">
                <input type="radio" name="payment" value="0" <?php if($isFree){ echo "checked";} ?>>Free
            </label>
            <label class="radio-inline">
                <input type="radio" name="payment" value="1" <?php if(!$isFree){ echo "checked";} ?>>Paid
            </label>
        </div>

        <div class="form-group">
            <div class="row">

                <div class='col-sm-3'>
                    <div class="form-group">
                        <label for="inputName" class="control-label">Start date</label>
                        <div class='input-group date' id='startDate'>
                            <input type='text' class="form-control" placeholder="Start date"
                                   name="startDate" value="<?php echo $course->startdate ?>" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class='col-sm-3'>
                    <div class="form-group">
                        <label for="inputName" class="control-label">End date</label>
                        <div class='input-group date' id='endDate'>
                            <input type='text' class="form-control" placeholder="End date"
                                   name="endDate" value="<?php echo $course->enddate ?>" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <div class="form-group">
        <button form="createCourseForm" type="submit" class="btn btn-primary">Save</button>
    </div>
</div>


<script type="text/javascript">
    function initDatePicker(id) {
        var dateTimeFormat = "<?php echo DateUtil::$DATE_FORMAT_HTML ?>"
        $(id).datetimepicker({format : dateTimeFormat});
    };

    initDatePicker("#startDate");
    initDatePicker("#endDate");
</script>


