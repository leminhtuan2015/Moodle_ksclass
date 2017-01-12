<div id="showDetailQuestionDialog" class="modal fade" role="dialog">
    <div class="modal-content modal-dialog modal-lg">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="">Detail</h4>
        </div>
        <div class="modal-body">
            <div id="questionDiv">
                <div class="form-group">
                    <label for="questionEditTxt">Question</label>
                    <textarea class="form-control new_question_input" placeholder="question" disabled><?php echo $question->questiontext ?></textarea>
                </div>
                <label>Answers</label>

                <?php foreach ($question->options->answers as $answer) { ?>
                    <div class="form-group">
                        <input class="new_question_input" type="radio" name="new_question_correct_answer"
                            <?php if($answer->fraction > 0){ echo "checked";} else {echo "disabled";}?>>
                        <input class="new_question_input"  placeholder="answer" disabled value="<?php echo $answer->answer ?>">
                    </div>
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