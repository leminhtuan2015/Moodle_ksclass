<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Course</div>
        <div class="container">
            <div class="col-md-4">
                <form id="createCourseForm" data-toggle="validator" role="form"
                      action="<?php echo "$formAction"; ?>" method="post">

                    <div class="form-group">
                        <label for="inputName" class="control-label" >Name</label>
                        <input type="text" name="name" class="form-control"
                               id="inputName" placeholder="Class name" value="<?php echo $course->fullname ?>" required>
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
                        <label for="inputName" class="control-label">Visibale</label>
                        <select class="form-control" id="sel2" name="visible">
                            <option value="1">Show</option>
                            <option value="0">Hide</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputName" class="control-label">Payment</label>
                        <select class="form-control" id="sel2" name="payment">
                            <option value="0" <?php if($isFree){ echo "selected";} ?>> Free</option>
                            <option value="1" <?php if(!$isFree){ echo "selected";} ?>>Cost</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="form-group">
        <button form="createCourseForm" type="submit" class="btn btn-primary">Save</button>
    </div>
</div>


