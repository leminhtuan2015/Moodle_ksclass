<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/17/16
 * Time: 2:26 PM
 */

?>


<div class="container">

    <form data-toggle="validator" role="form" action="/moodle/koolsoft/category/?action=create" method="post">
        <div class="form-group">
            <label for="parentId" class="control-label">Parent Category</label>
            <select class="form-control" id="parentId" name="parentId">
                <?php
                    foreach ($categoriesName as $key => $categoryName) {
                        echo "<option value='$key'> $categoryName </option>";
                    }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="name" class="control-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Category name" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>


