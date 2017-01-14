<link rel="stylesheet" type="text/css" href="resources/css/question.css">

<script src="resources/javascripts/question.js"></script>

<div id="modal_container">
</div>


<?php
    global $CFG;

    require_once ($CFG->dirroot."/koolsoft/shared/views/alert_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/confirm_dialog.php");
?>

<div class="container" style="margin-top: 20px">
    <div class="container">
        <a href="#" id="open_new_question_diaglog" class="btn btn-success" data-toggle="modal" data-target="#newQuestionDialog">
            <span class="glyphicon glyphicon-plus-sign"></span>
        </a>

        <?php require_once ("import_form.php")?>

    </div>

    <?php include ("paging.php")?>

    <br>

    <div id="question_list">
        <?php require_once ("question_list.php")?>
    </div>
</div>

<?php require_once ("new.php");?>

<script>
    getByTag(1);
</script>
