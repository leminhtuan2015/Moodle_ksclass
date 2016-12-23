<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/22/16
 * Time: 8:39 AM
 */
?>
<script src="resources/javascript/quiz.js"></script>

<div class="container">
    <?php
        if($currentQuiz){
            echo "<h4>Edit quiz <span class='label label-default'></span></h4>";
        }else {
            echo "<h4>Create new quiz <span class='label label-default'></span></h4>";
        }
    ?>
    <form data-toggle="validator" role="form" action="?action=edit&course=<?php echo $courseid?>&section=<?php echo $section?>" method="post" id="formQuiz">
        <div style="display: none" class="form-group">
            <input id="idQuiz" name="idQuiz" value="<?php echo $id?>">
            <input id="saveAction" name="saveAction" value="saveQuiz">
            <input id="idQuestions" name="idQuestions" value="">
            <input id="idSlotRemoves" name="idSlotRemoves" value="">
        </div>
        <div class="form-group">
            <label for="nameQuiz" class="control-label">Name</label>
            <input id="nameQuiz" placeholder="quiz name" class="form-control" <?php if($currentQuiz){ echo 'disabled';}?> name="nameQuiz" value="<?php if($currentQuiz){ echo $currentQuiz->name;}?>">
        </div>
        <div class="form-group">
            <label for="descQuiz" class="control-label">Description</label>
            <input id="descQuiz" placeholder="quiz description" class="form-control" <?php if($currentQuiz){ echo 'disabled';}?> name="descQuiz" value="<?php if($currentQuiz){ echo $currentQuiz->intro;}?>">
        </div>
    </form>
    <table class='table'>
        <thead>
        <tr>
            <th class="col-md-2"><input type='checkbox' value='' id='idCheckBoxQuestionAll'></th>
            <th class="col-md-2">STT</th>
            <th class="col-md-8">Question</th>
        </tr>
        </thead>
        <tbody id="bodyTableQuestion">

        </tbody>
    </table>
    <div class="form-group">
        <button class="btn" id="btnAddQuestion">Add question</button>
        <button class="btn" id="btnDeleteQuestion">Delete question</button>
    </div>
    <div class="form-group">
        <button type="submit" form="formQuiz" class="btn btn-primary" id="saveQuiz">Save</button>
    </div>
</div>

<?php
    global $CFG;
    require_once ("question_bank_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/alert_dialog.php");
?>