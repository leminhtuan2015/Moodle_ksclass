<form id="<?php echo $form_id ?>">
    <div id="questionDiv">
        <div class="form-group">
            <label for="questionEditTxt">Question</label>
            <textarea class="form-control" placeholder="question" id="questionEditTxt<?php echo $question->id ?>"><?php if($question->data->questiontext){echo $question->data->questiontext;}?></textarea>
        </div>
        <label>Answers</label>

        <?php foreach ($question->data->options->answers as $answer) { ?>
            <div class="form-group">
                <input type="radio" name="correct_answer<?php echo $question->id ?>" id="correct_answer<?php echo $answer->id ?>"<?php if($answer->fraction > 0){ echo "checked";}?>>
                <input id="edit_question_answer<?php echo $answer->id ?>" placeholder="answer" value="<?php echo $answer->answer ?>">
            </div>
        <?php } ?>

        <div class="form-group">
            <label for="selectTagEditQuestion">Tags</label>
            <select multiple="true" style="width: 100%" id="selectTagEditQuestion"> </select>
        </div>

    </div>
</form>