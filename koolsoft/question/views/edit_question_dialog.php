<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/21/16
 * Time: 6:16 PM
 */
?>
<style>

</style>

<div id="editQuestionDialog<?php echo $question->id ?>" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="">Edit question: <?php echo $question->data->questiontext ?></h4>
            </div>
            <div class="modal-body">
                    <div id="questionDiv">
                        <div class="form-group" style="display: none;">
                            <label for="questionEditTxt">Id</label>
                            <input class="form-control" placeholder="question" id="questionEditId">
                        </div>
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
                    <div class="form-group">
                        <label style="display: none; color: #ff5f50;" id="editQuestionErrorText"></label>
                    </div>
                    <br>
            </div>
            <div class="modal-footer">
                <button type="button submit" class="btn btn-primary" id="saveEditQuestion">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>