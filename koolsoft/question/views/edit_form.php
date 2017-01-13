<form id="<?php echo $form_id ?>">
    <div id="questionDiv">
        <div class="form-group">
            <label class="text-primary">Question</label>
            <textarea class="form-control" placeholder="question" id="questionEditTxt<?php echo $question->id ?>"><?php if($question->data->questiontext){echo $question->data->questiontext;}?></textarea>
        </div>

        <?php foreach ($question->options->answers as $answer) { ?>
            <?php if($answer->fraction > 0){?>
                <label class="text-success">Correct Answer </label>
                <div class="form-group">
                    <input id="edit_question_answer<?php echo $answer->id ?>"
                           value="<?php if($answer->answer != rest_question::$EMPTY_QUESTION) {echo $answer->answer;} ?>"/>
                </div>
                <label class="text-danger">Wrong Answers</label>
            <? } else { ?>
                <div class="form-group">
                    <input id="edit_question_answer<?php echo $answer->id ?>"
                           value="<?php if($answer->answer != rest_question::$EMPTY_QUESTION) {echo $answer->answer;} ?>"/>
                </div>
            <?php } ?>
        <?php } ?>


        <div class="form-group">
            <label for="selectTagEditQuestion">Tags</label>
            <select multiple="true" style="width: 100%" id="selectTagEditQuestion"> </select>
        </div>

    </div>
</form>