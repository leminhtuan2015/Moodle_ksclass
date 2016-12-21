<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/17/16
 * Time: 1:45 PM
 */

?>

<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Course</div>

        <form id="createCourseForm" data-toggle="validator" role="form" action="/moodle/koolsoft/course/?action=create" method="post">
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
        </form>
    </div>

    <div id="lectures">
        <div class="panel panel-success">
            <div class="panel-heading">
                <a data-toggle="collapse" data-target="#courseDetail" href="#courseDetail">Lecture</a>
            </div>

            <div id="courseDetail" class="panel-collapse collapse in">
                <div class="form-group">
                    <label for="inputName" class="control-label" >Lecture Name</label>
                    <input form="createCourseForm" type="text" name="lectures[1][name]" class="form-control" placeholder="Lecture Name" required>
                </div>

                <div class="form-group">
                    <label for="inputName" class="control-label" >Lecture Content</label>
                    <input form="createCourseForm" type="text" name="lectures[1][content]" class="form-control" placeholder="Lecture Content" required>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 50px">
        <a type="button" class="btn btn-success pull-right" href="" id="addLectureButton">
            Add Lecture
        </a>
    </div>

    <div class="form-group">
        <button form="createCourseForm" type="submit" class="btn btn-primary">Create</button>
    </div>

</div>


<script src="/moodle/koolsoft/course/resources/addfield.js"></script>