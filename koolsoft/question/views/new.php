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
                <?php require_once ("new_form.php")?>
            </div>
        </div>
        <div class="modal-footer">
            <button href="#" id="add_question" class="btn btn-success pull-left">
                <span class="glyphicon glyphicon-plus-sign"></span>
            </button>
            <button form="<?php echo $form_id ?>" type="submit" class="btn btn-primary" id="saveNewQuestion">Save</button>
        </div>
    </div>
</div>

<script>
    var questionsData = []
    var currentQuestionNumber = 0
    var currentQuestionActiveIndex = 0

    function clear(){
        questionsData = []
        currentQuestionNumber = 0

        $("#new_question_list").empty();
        $("#new_question_question_text").val("")
    }
    
    function emptyForm() {
        $("#new_question_question_text").val("")
        $("#new_question_question_correct_answer").val("");
        <?php for ($i = 0; $i < 3; $i++) { ?>
            $("#new_question_question_wrong_answer<?php echo $i?>").val("");
        <?php } ?>
    }

    function createEmptyQuestionData() {
        var question = {
            "id": "",
            "question": "",
            "answer": "",
            "wrongAnswer": ["","",""],
            "tags": [],
            "qtype": "multichoice"
        }
        questionsData[currentQuestionNumber] = question
    }
    
    function appendQuestionLinkWhenCreateNew() {
        $("#new_question_list").empty();

        for (var i = 0; i < questionsData.length; i++) {
            var link = "<a href='#' class='question_link' " + "id='" + "question_" + i +"'" + ">" + "Question : " + i + "</a><br>"
            $("#new_question_list").append(link);

            $("#question_"+i).click(function (event) {
                id = event.target.id.replace("question_", "")

                setActiveHtmlQuestionLink(id)
                displayQuestionDataToForm(id)
            });
        }

        setActiveHtmlQuestionLink(currentQuestionNumber)
    }

    function setActiveHtmlQuestionLink(id){
        $(".question_link").css('color', '');
        $("#question_"+id).css('color', 'red');

        currentQuestionActiveIndex = id
    }
    
    function displayQuestionDataToForm(id) {
        question = questionsData[id]
        emptyMark = "<?php echo QuestionController::$EMPTY_QUESTION?>"

        if(question.question == emptyMark){
            question.question = ""
        }

        if(question.answer == emptyMark){
            question.answer = ""
        }

//        alert(JSON.stringify(questionsData))
        $("#new_question_question_text").val(question.question)
        $("#new_question_question_correct_answer").val(question.answer);

        <?php for ($i = 0; $i < 3; $i++) { ?>
            wa = question.wrongAnswer[<?php echo $i?>]

            if(wa == emptyMark){
                wa = ""
            }

            $("#new_question_question_wrong_answer<?php echo $i?>").val(wa);
        <?php } ?>

    }

    function saveQuestionOnLocal(){
        question = questionsData[currentQuestionActiveIndex]
        emptyMark = "<?php echo QuestionController::$EMPTY_QUESTION?>"

        questionTextVal = $("#new_question_question_text").val()
        correctAnswerVal = $("#new_question_question_correct_answer").val();
        wrongAnswerVal = []

        <?php for ($i = 0; $i < 3; $i++) { ?>
            wa = $("#new_question_question_wrong_answer<?php echo $i ?>").val()
            wrongAnswerVal.push(wa || emptyMark)
        <?php } ?>

        question.question = questionTextVal
        question.answer = correctAnswerVal || emptyMark
        question.wrongAnswer = wrongAnswerVal;
    }
    
    function isLastQuestionIsActive() {
        return currentQuestionActiveIndex == currentQuestionNumber
    }
    
    function validateNewQuestionForm() {
        if(isLastQuestionIsActive()){
            questionText = $("#new_question_question_text").val()

            if(!questionText){
                return false
            }
        } else {
            lastQuestion = questionsData[currentQuestionNumber]

            if(!lastQuestion.question){
                displayQuestionDataToForm(currentQuestionNumber)
                setActiveHtmlQuestionLink(currentQuestionNumber)
                return false
            }
        }

        return true
    }

    function cleanDataBeforeSubmit(questionsData){

        questionsDataCleaned = []

        for (i = 0; i < questionsData.length; i++) {

            if(questionsData[i].question != ""){
                questionsDataCleaned.push(questionsData[i])
            }
        }

        return questionsDataCleaned;
    }

    $("#open_new_question_diaglog").click(function () {
        clear()
        createEmptyQuestionData()
        appendQuestionLinkWhenCreateNew()
        displayQuestionDataToForm(0)
    });

    $("#saveNewQuestion").click(function () {

//       {"questions":"[{\"id\":\"undefined\",\"question\":\"4\",\"answer\":\"4\",\"qtype\":\"multichoice\",\"tags\":[],\"wrongAnswer\":[\"4\",\"4\",\"4\"]}]"}

        questionsData = cleanDataBeforeSubmit(questionsData)

        var data = {"questions" : JSON.stringify(questionsData)};

//        alert(JSON.stringify(questionsData))

        $.post({url: "/moodle/koolsoft/question/rest/index.php?action=create"
            , data : data
            , success: function(result){
                $("#newQuestionDialog").modal("hide")
                $("#question_list_table_body").prepend(result)
            }
        });
    });

    $("#add_question").click(function () {

        if(!validateNewQuestionForm()){
            alert("Please fill the form")
            return
        }

        emptyForm()

        currentQuestionNumber += 1

        createEmptyQuestionData()
        appendQuestionLinkWhenCreateNew()
    });

    $( ".new_question_input" ).change(function() {
        saveQuestionOnLocal()
    });


</script>