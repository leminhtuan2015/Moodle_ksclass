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
    }

    function createEmptyQuestionData() {
        var question = {
            "id": "",
            "question": "",
            "answer": "Answer",
            "wrongAnswer": ["1","2","3"],
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
//        alert(JSON.stringify(questionsData))
        $("#new_question_question_text").val(question.question)
    }

    function saveQuestionOnLocal(){
        question = questionsData[currentQuestionActiveIndex]

        questionTextVal = $("#new_question_question_text").val()
        wrongAnswer = []
        correctAnswer = "Answer"

        <?php for ($i = 0; $i < 4; $i++) { ?>
            answer = $("#new_question_question_answer<?php echo $i ?>").val()
            correct = $('input[id=new_question_correct_answer<?php echo $i ?>]:checked').val()

            if(correct){
                correctAnswer = answer
                if(!correctAnswer){correctAnswer = "Correct_Answer"}
            } else {
                if(!answer){answer = "Answer_<?php echo $i ?>"}
                wrongAnswer.push(answer)
            }
        <?php } ?>

        question.question = questionTextVal
        question.answer = correctAnswer
        question.wrongAnswer = wrongAnswer;
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

    $("#open_new_question_diaglog").click(function () {
        clear()
        createEmptyQuestionData()
        appendQuestionLinkWhenCreateNew()
        displayQuestionDataToForm(0)
    });

    $("#saveNewQuestion").click(function () {

//       {"questions":"[{\"id\":\"undefined\",\"question\":\"4\",\"answer\":\"4\",\"qtype\":\"multichoice\",\"tags\":[],\"wrongAnswer\":[\"4\",\"4\",\"4\"]}]"}

        var data = {"questions" : JSON.stringify(questionsData)};

//        alert(JSON.stringify(data))

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