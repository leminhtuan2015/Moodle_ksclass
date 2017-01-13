<form id="<?php echo "$form_id" ?>">
    <div id="questionDiv">
        <div class="form-group">
            <label class="text-primary">Question</label>
            <textarea class="form-control new_question_input" placeholder="question" id="new_question_question_text"></textarea>
        </div>
        <label class="text-success">Correct Answer </label>
        <div class="form-group">
            <input class="new_question_input" id="new_question_question_correct_answer" placeholder="correct answer"/>
        </div>

        <label class="text-danger">Wrong Answers</label>
        <?php for ($i = 0; $i < 3; $i++) { ?>
            <div class="form-group">
                <input class="new_question_input" id="new_question_question_wrong_answer<?php echo $i?>"
                       placeholder="wrong answer <?php echo $i?>"/>
            </div>
        <?php } ?>

        <div class="form-group">
            <label for="selectTagEditQuestion">Tags</label>
            <select multiple="true" style="width: 100%" id="selectTagEditQuestion"> </select>
        </div>
    </div>
</form>