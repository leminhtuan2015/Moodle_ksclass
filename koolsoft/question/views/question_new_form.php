<form id="<?php echo "$form_id" ?>">
    <div id="questionDiv">
        <div class="form-group">
            <label for="questionEditTxt">Question</label>
            <textarea class="form-control new_question_input" placeholder="question" id="new_question_question_text"></textarea>
        </div>
        <label>Answers</label>

        <?php for ($i = 0; $i < 4; $i++) { ?>
            <div class="form-group">
                <input class="new_question_input" type="radio" name="new_question_correct_answer" id="correct_answer<?php echo $i?>">
                <input class="new_question_input" id="new_question_question_answer<?php echo $i?>" placeholder="answer"">
            </div>
        <?php } ?>

        <div class="form-group">
            <label for="selectTagEditQuestion">Tags</label>
            <select multiple="true" style="width: 100%" id="selectTagEditQuestion"> </select>
        </div>

    </div>
</form>