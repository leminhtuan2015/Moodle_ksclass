<div id="showDetailQuestionDialog" class="modal fade" role="dialog">
    <div class="modal-content modal-dialog modal-lg">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="">Detail</h4>
        </div>
        <div class="modal-body">
            <div id="questionDiv">
                <div class="form-group">
                    <label class="text-primary">Question</label>
                    <textarea class="form-control new_question_input" placeholder="question" disabled><?php echo $question->questiontext ?></textarea>
                </div>

                <?php foreach ($question->options->answers as $answer) { ?>
                    <?php if($answer->fraction > 0){?>
                        <label class="text-success">Correct Answer </label>
                        <div class="form-group">
                            <input disabled value="<?php if($answer->answer != rest_question::$EMPTY_QUESTION) {echo $answer->answer;} ?>"/>
                        </div>
                        <label class="text-danger">Wrong Answers</label>
                    <? } else { ?>
                        <div class="form-group">
                            <input disabled value="<?php if($answer->answer != rest_question::$EMPTY_QUESTION) {echo $answer->answer;} ?>"/>
                        </div>
                    <?php } ?>
                <?php } ?>

                <div class="form-group">
                    <label for="selectTagEditQuestion">Tags</label>
                    <select multiple="true" style="width: 100%" id="selectTagEditQuestion"> </select>
                </div>

            </div>


        </div>
        <div class="modal-footer">

        </div>
    </div>
</div>