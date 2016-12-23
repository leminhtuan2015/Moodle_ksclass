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
    <form data-toggle="validator" role="form" action="?action=edit&course=<?php echo $courseid?>&section=<?php echo $section?>" method="post" id="formQuiz">
        <div style="display: none" class="form-group">
            <input id="idQuiz" name="idQuiz" value="<?php echo $id?>">
            <input id="saveAction" name="saveAction" value="saveQuiz">
            <input id="idQuestions" name="idQuestions" value="">
        </div>
        <div class="form-group">
            <label for="nameQuiz" class="control-label">Name</label>
            <input id="nameQuiz" placeholder="quiz name" class="form-control" name="nameQuiz">
        </div>
        <div class="form-group">
            <label for="descQuiz" class="control-label">Description</label>
            <input id="descQuiz" placeholder="quiz description" class="form-control" name="descQuiz">
        </div>
    </form>
    <table class='table'>
        <thead>
        <tr>
            <th></th>
            <th>Question</th>
        </tr>
        </thead>
        <tbody id="bodyTableQuestion">

        </tbody>
    </table>
    <div class="form-group">
        <button class="btn" id="btnAddQuestion">Add question</button>
    </div>
    <div class="form-group">
        <button type="submit" form="formQuiz" class="btn btn-primary">Save</button>
    </div>
</div>

<?php
    require_once ("question_bank_dialog.php");
?>