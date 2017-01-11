<script>
    $(function () {
        $("#edit_quest_form_<?php echo $question->id ?>").on('submit', function (e) {
            e.preventDefault();

            data = "[{"id":"undefined","question":"55","answer":"55 5","qtype":"multichoice","tags":[],"wrongAnswer":["55","55","55"]}]"

            id =

            alert(data + "dc")

            $.ajax({
                type: 'post',
                url: 'post.php',
                data: data,
                success: function () {
                    alert('form was submitted');
                }
            });
        });
    });
</script>

<div id="editQuestionDialog<?php echo $question->id ?>" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="">Edit question: <?php echo $question->data->questiontext ?></h4>
            </div>
            <div class="modal-body">
                <form id="edit_quest_form_<?php echo $question->id ?>">
                    <div id="questionDiv">
                        <div class="form-group">
                            <label for="questionEditTxt">Question</label>

                            <textarea class="form-control" placeholder="question" id="questionEditTxt"><?php if($question->data->questiontext){echo $question->data->questiontext;}?></textarea>

                        </div>

                        <label>Answers</label>

                        <?php foreach ($question->data->options->answers as $answer) { ?>
                            <div class="form-group">
                                <input type="radio" name="correct_answer<?php echo $question->id ?>" value="1" <?php if($answer->fraction > 0){ echo "checked";}?> >
                                <input class="" placeholder="answer" value="<?php echo $answer->answer ?>">
                            </div>
                        <?php } ?>


                        <div class="form-group">
                            <label for="selectTagEditQuestion">Tags</label>
                            <select multiple="true" style="width: 100%" id="selectTagEditQuestion"> </select>
                        </div>

                    </div>
                </form>

                    <div class="form-group">
                        <label style="display: none; color: #ff5f50;" id="editQuestionErrorText"></label>
                    </div>
                    <br>
            </div>
            <div class="modal-footer">
                <button form="edit_quest_form_<?php echo $question->id ?>"
                        type="submit" class="btn btn-primary" id="saveEditQuestion">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>