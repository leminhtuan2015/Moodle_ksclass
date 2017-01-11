<?php $form_id = "new_quest_form" ?>

<div id="newQuestionDialog" class="modal fade" role="dialog">
    <div class="modal-content modal-dialog modal-lg">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="">New</h4>
        </div>
        <div class="modal-body row">

            <div class="col-md-4">
                <div id="new_question_list">
                </div>

            </div>
            <div class="col-md-8">
                <?php require_once ("question_new_form.php")?>
            </div>
        </div>
        <div class="modal-footer">
            <button href="#" id="add_question" class="btn btn-success pull-left">
                <span class="glyphicon glyphicon-plus-sign"></span>
            </button>
            <button form="<?php echo $form_id ?>" type="submit" class="btn btn-primary" id="saveEditQuestion">Save</button>
        </div>
    </div>
</div>

<script>
    var questionsData = []

    function clear(){
        questionsData = []
        $("#new_question_list").empty();
    }

    function prepareData() {
        questionsData.push({"questionText": new Date() + ""})
    }
    
    function renderQuestionLink() {
        $("#new_question_list").empty();

        for (var i = 0; i < questionsData.length; i++) {
            var link = "<a href='#' " + "id='" + "question_" + i +"'" + ">" + "Question : " + i + "</a><br>"
            $("#new_question_list").append(link);

            $("#question_"+i).click(function (event) {
                id = event.target.id.replace("question_", "")
                alert(id)
                renderQuestionToForm(id)
            });
        }
    }
    
    function renderQuestionToForm(id) {
        question = questionsData[id]

        alert(JSON.stringify(question))
    }

    function saveQuestion(){
        questionsData.push({"questionText": new Date() + ""})
    }

    $("#open_new_question_diaglog").click(function () {
        clear()
        prepareData()
        renderQuestionLink()
    });

    $("#add_question").click(function () {
        saveQuestion()

        renderQuestionLink()
    });


</script>