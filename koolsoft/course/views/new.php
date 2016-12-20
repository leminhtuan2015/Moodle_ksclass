<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/17/16
 * Time: 1:45 PM
 */

?>

<div class="container">

    <form data-toggle="validator" role="form" action="/moodle/koolsoft/course/?action=create" method="post">
        <div class="form-group">
            <label for="inputName" class="control-label" >Name</label>
            <input type="text" name="name" class="form-control" id="inputName" placeholder="Class name" required>
        </div>

        <div class="form-group">
            <label for="inputName" class="control-label">Category</label>
            <select class="form-control" name="categoryId" id="sel2">
                <?php
                    foreach ($categoriesName as $key => $categoryName) {
                        echo "<option value='$key'> $categoryName </option>";
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
