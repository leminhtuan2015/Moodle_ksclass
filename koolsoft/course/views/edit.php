<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/17/16
 * Time: 1:45 PM
 */

?>

<div class="container">

    <form data-toggle="validator" role="form">
        <div class="form-group">
            <label for="inputName" class="control-label">Name</label>
            <input type="text" class="form-control" id="inputName" placeholder="Class name" required>
        </div>

        <div class="form-group">
            <label for="inputName" class="control-label">Category</label>
            <select class="form-control" id="sel2">
                <option>Category 1</option>
                <option>Category 2</option>
            </select>
        </div>

        <div class="form-group">
            <label for="inputName" class="control-label">Visibale</label>
            <select class="form-control" id="sel2">
                <option>Show</option>
                <option>Hide</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</div>
