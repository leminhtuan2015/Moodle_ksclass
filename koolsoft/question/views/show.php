<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/19/16
 * Time: 10:24 PM
 */
?>
<link rel="stylesheet" type="text/css" href="resources/css/question.css">
<script src="resources/javascript/question.js"></script>

<div class="container">
    <a href="#" id="showAddQuestionDialog" class="btn btn-info btn-lg">
        <span class="glyphicon glyphicon-plus-sign"></span> Add question
    </a>
<!--    <a href="#" id="showAddToQuizDialog" class="btn btn-info btn-lg">-->
<!--        <span class="glyphicon glyphicon-list-alt"></span> Add to quiz-->
<!--    </a>-->
    <a href="#" id="showCopyQuestionDialog" class="btn btn-info btn-lg">
        <span class="glyphicon glyphicon-duplicate"></span> Copy
    </a>
    <select multiple="true" style="width: 50%" id="selectTagSearch">

    </select>
</div>

<div class="container">
    <table class="table table-hover">
        <thead>
        <tr>
            <td>No</td>
            <td>Tag name</td>
            <td>Date modified</td>
        </tr>
        </thead>
        <tbody id="idBodyTableQuestion">

        </tbody>
    </table>
    <br>
    <br>
    <br>
    <a href="/moodle/koolsoft/question_tag/?action=show">
        You can create new tag
    </a>
</div>


<?php
global $CFG;
    require_once ("create_question_dialog.php");
    require_once ("add_question_to_quiz_dialog.php");
    require_once ("edit_question_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/alert_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/confirm_dialog.php");
?>

