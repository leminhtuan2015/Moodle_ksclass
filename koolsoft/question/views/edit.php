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
            questionText = $("#questionEditTxt<?php echo $question->id ?>").val()
            wrongAnswer = []
            correctAnswer = null

            <?php foreach ($question->data->options->answers as $answer) { ?>
                answer = $("#edit_question_answer<?php echo $answer->id ?>").val()
                correct = $('input[id=correct_answer<?php echo $answer->id ?>]:checked').val()

                if(correct){
                    correctAnswer = answer
                } else {
                    wrongAnswer.push(answer)
                }

            <?php } ?>

            question = {};
            question.id = id
            question.question = questionText
            question.answer = correctAnswer
            question.wrongAnswer = wrongAnswer;
            question.tags = ""
            question.qtype = "multichoice";

            questions = [];
            questions.push(question);

            data = {"questions" : JSON.stringify(questions)};

            $.ajax({
                type: 'post',
                url: '/moodle/koolsoft/question/rest/index.php/?action=create',
                data: data,
                success: function () {
                    $("#editQuestionDialog<?php echo $question->id ?>").modal('hide');

//                    getByTag();
                }
            });
        });
    });
</script>