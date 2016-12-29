<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/27/16
 * Time: 9:44 AM
 */
?>
<script src="/moodle/koolsoft/question_categories/resources/javascript/question_categories.js"></script>
<div class="container">
    <div style="display: none">
        <input id="userId" value="<?php echo $USER->id?>">
        <input id="categoryParentId" value="<?php echo $id?>">
    </div>
    <div>
        <h4 style="display: inline-block" id="headerLibrary">Library</h4>
        <div class="dropdown" style="display: inline-block; float: right;">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu">
                <li id="btnShowCreateCategoryDialog">
                    <a>
                        Add topic
                    </a>
                </li>
                <li id="btnCreateExercise">
                    <a >
                        Add excerise
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <br>
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
    global $CFG;
    require_once ("create_category_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/alert_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/confirm_dialog.php");
?>
