<div class="container">

    <form id="createCourseForm" data-toggle="validator" role="form"
          action="<?php echo "$formAction"; ?>" method="post">

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
            <label>Privacy</label>
            <br>
            <label class="radio-inline">
                <input type="radio" name="visible" value="1" checked>Public
            </label>
            <label class="radio-inline">
                <input type="radio" name="visible" value="0">Private
            </label>
        </div>


        <input type="hidden" name="id" value="<?php echo $course->id ?>">

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
            <label for="inputName" class="control-label">Payment</label>
            <select class="form-control" id="sel2" name="payment">
                <option value="0" <?php if($isFree){ echo "selected";} ?>> Free</option>
                <option value="1" <?php if(!$isFree){ echo "selected";} ?>>Cost</option>
            </select>
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
                            <input type='text' class="form-control" placeholder="Start date"/>
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $('#startDate').datetimepicker();
                    });
                </script>

                <div class='col-sm-3'>
                    <div class="form-group">
                        <label for="inputName" class="control-label">End date</label>
                        <div class='input-group date' id='endDate'>
                            <input type='text' class="form-control" placeholder="End date"/>
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $('#endDate').datetimepicker();
                    });
                </script>
            </div>
        </div>

    </form>

    <div class="form-group">
        <button form="createCourseForm" type="submit" class="btn btn-primary">Save</button>
    </div>
</div>



