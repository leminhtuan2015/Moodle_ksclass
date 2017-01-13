<script src="/moodle/koolsoft/question_categories/resources/javascript/question_categories.js"></script>

<div class="container" style="margin-top: 20px">
    <div style="display: none">
        <input id="userId" value="<?php echo $USER->id?>">
        <input id="categoryParentId" value="<?php echo $id?>">
    </div>
    <div>
        <button class="btn btn-primary dropdown-toggle" id="btnShowCreateCategoryDialog">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
    </div>
    <br>

    <table class="table table-hover">
        <thead>
        <tr>
            <td></td>
        </tr>
        </thead>
        <tbody id="idBodyTableCategories">
        </tbody>
    </table>
</div>

<?php
require_once ("create_category_dialog.php");
require_once ($CFG->dirroot."/koolsoft/shared/views/alert_dialog.php");
require_once ($CFG->dirroot."/koolsoft/shared/views/confirm_dialog.php");
?>
