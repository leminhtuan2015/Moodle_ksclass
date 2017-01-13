<?php $form_id = "edit_quest_form_".$question->id ?>

<div id="editQuestionDialog<?php echo $question->id ?>" class="modal fade" role="dialog">
    <div class="modal-content modal-dialog modal-lg">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="">Edit question: <?php echo $question->data->questiontext ?></h4>
        </div>
        <div class="modal-body">
                <?php include ("edit_form.php")?>

            <div class="form-group">
                <label style="display: none; color: #ff5f50;" id="editQuestionErrorText"></label>
            </div>
            <br>
        </div>
        <div class="modal-footer">
            <button form="<?php echo $form_id ?>" type="submit" class="btn btn-primary" id="saveEditQuestion">Save</button>
        </div>
    </div>
</div>

<script>
    // SUBMIT FORM BY AJAX
    $(function () {
        $("#<?php echo $form_id ?>").on('submit', function (e) {
            e.preventDefault();

            id = "<?php echo "$question->id" ?>"
            questionTextVal = $("#questionEditTxt<?php echo $question->id ?>").val()
            correctAnswerVal = ""
            wrongAnswerVal = []

            <?php foreach ($question->data->options->answers as $answer) { ?>
                answer = $("#edit_question_answer<?php echo $answer->id ?>").val()

                <?php if($answer->fraction > 0){?>
                    correctAnswerVal = answer || "<?php echo rest_question::$EMPTY_QUESTION?>"
                <?php } else { ?>
                    wrongAnswerVal.push(answer || "<?php echo rest_question::$EMPTY_QUESTION?>")
                <?php }?>
            <?php } ?>

            question = {};
            question.id = id
            question.question = questionTextVal
            question.answer = correctAnswerVal
            question.wrongAnswer = wrongAnswerVal;
            question.tags = ""
            question.qtype = "multichoice";

            questions = [];
            questions.push(question);

            data = {"questions" : JSON.stringify(questions)};

            $.ajax({
                type: 'post',
                url: '/moodle/koolsoft/question/rest/index.php/?action=update',
                data: data,
                success: function (result) {
                    $("#editQuestionDialog<?php echo $question->id ?>").modal('hide');

                    $("#question_list_table_row_<?php echo $question->id ?>").html(result)

                }
            });
        });
    });
</script>