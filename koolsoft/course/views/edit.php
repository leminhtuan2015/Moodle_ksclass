<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/20/16
 * Time: 3:02 PM
 */
?>


<div class="container">

    <form data-toggle="validator" role="form" action="/moodle/koolsoft/course/?action=update" method="post">
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
    <button type="submit" class="btn btn-primary">Create</button>
</div>
</form>
</div>