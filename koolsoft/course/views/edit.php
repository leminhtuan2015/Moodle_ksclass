<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/20/16
 * Time: 3:02 PM
 */
?>


<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Course</div>

        <form id="createCourseForm" data-toggle="validator" role="form" action="/moodle/koolsoft/course/?action=update" method="post">
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
        </form>
    </div>

    <div id="lectures">
        <?php foreach ($sections as $index => $section) { ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <a data-toggle="collapse" data-target="#courseDetail<?php echo $section->section ?>" href="#courseDetail">
                        <?php echo "$section->name ($section->section)"?>
                    </a>
                </div>

                <div id="courseDetail<?php echo $section->section ?>" class="panel-collapse collapse in">
                    <div class="form-group">
                        <label for="inputName" class="control-label" >Lecture Name</label>
                        <input form="createCourseForm" type="hidden"
                               name="lectures[<?php echo $index ?>][sectionId]" value="<?php echo $section->id ?>">
                        <input form="createCourseForm" type="hidden"
                               name="lectures[<?php echo $index ?>][section]" value="<?php echo $section->section ?>">
                        <input form="createCourseForm" type="text"
                               name="lectures[<?php echo $index ?>][name]" class="form-control"
                               placeholder="Lecture Name" required
                               value="<?php echo "$section->name ($section->section)"?>">
                    </div>

                    <?php
                        $content = "";

                        foreach ($section->modinfo->cms as $cms) {
                            if ($cms->section == $section->id) {
                                if ($cms->content) {
                                    $content = "$cms->content";
                                }
                                if ($cms->url) {
//                                    echo "<li><a href='$cms->url' > - $cms->name </a> ($cms->section)</li>";
                                }
                            }
                        }
                    ?>

                    <div class="form-group">
                        <label for="inputName" class="control-label" >Lecture Content</label>
                        <input form="createCourseForm" type="text"
                               name="lectures[<?php echo $index ?>][content]" class="form-control"
                               placeholder="Lecture Content" required
                               value="<?php echo $section->section ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div style="margin-bottom: 50px">
        <a type="button" class="btn btn-success pull-right" href="#" id="addLectureButton">
            Add Lecture
        </a>
    </div>

    <div class="form-group">
        <button form="createCourseForm" type="submit" class="btn btn-primary">Save</button>
    </div>
</div>

<script src="/moodle/koolsoft/course/resources/addfield.js"></script>

