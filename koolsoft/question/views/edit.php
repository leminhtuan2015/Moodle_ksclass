<?php $form_id = "edit_quest_form_".$question->id ?>

<script>
    $(function () {
        $("#edit_quest_form_<?php echo $question->id ?>").on('submit', function (e) {
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

            <? } ?>

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

                    getByTag();
                }
            });
        });
    });
</script>

<div id="editQuestionDialog<?php echo $question->id ?>" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?php include ("form.php")?>
    </div>
</div>