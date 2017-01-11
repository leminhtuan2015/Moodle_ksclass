<link rel="stylesheet" type="text/css" href="resources/css/question.css">

<script src="resources/javascript/question.js"></script>
<script src="resources/javascript/rest_question.js"></script>

<div class="container" style="margin-top: 20px">
    <div class="container">
        <a href="#" id="showAddQuestionDialog" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus-sign"></span> New question
        </a>

        <a href="#" id="showCopyQuestionDialog" class="btn btn-primary">
            <span class="glyphicon glyphicon-duplicate"></span> Copy
        </a>

        <select multiple="true" style="width: 50%" id="selectTagSearch"></select>
    </div>

    <br>

    <div id="question_list">
        <?php require_once ("question_list.php")?>
    </div>
</div>

<?php
global $CFG;
    require_once ("create_question_dialog.php");
    require_once ("add_question_to_quiz_dialog.php");
    require_once ("edit_question_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/alert_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/confirm_dialog.php");
?>

