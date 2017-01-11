var Ks = Ks || {};
Ks.question = Ks.question || {};
Ks.question.wrongAnswerInputId = "wrongAnserTxt";
Ks.question.checkboxQuestionId = "checkboxQuestion";
Ks.question.numberQuestion = 0;
Ks.question.currentQuestion = {};
Ks.question.numberWrongAnswer = 3;
Ks.question.questions = {};
Ks.question.tags = [];
Ks.question.no = 0;
Ks.question.noCurrent = 0;
Ks.question.idQuestionBtns = [];

Ks.question.init = function () {
    $.ajax({url: "/moodle/koolsoft/question_tag/rest/question_tag.php?action=listAll",
        success: function(results){
            var tags = JSON.parse(results);
            var keys = Object.keys(tags);
            $("#idBodyTableTag").html("");
            for(var i = 0 ;  i < keys.length; i ++ ){
                var tag = {};
                tag.id = tags[keys[i]].id;
                tag.text = tags[keys[i]].name;
                Ks.question.tags.push(tag);
            }

            $("#selectTagSearch").select2({
                data: Ks.question.tags,
                tags: true,
                tokenSeparators: [',', ' ']
            });

            $("#selectTag").select2({
                data: Ks.question.tags,
                tags: true,
                tokenSeparators: [',', ' ']
            });

            $("#selectTagEditQuestion").select2({
                data: Ks.question.tags,
                tags: true,
                tokenSeparators: [',', ' ']
            });
        },
        error: function () {
            console.log("get tag error !!!!!");
        }
    });

    Ks.question.handler();
    Ks.question.getQuestions();
};

Ks.question.initCreateQuestion = function (questions) {
    Ks.question.numberWrongAnswer = 3;
    Ks.question.questions = questions;
    Ks.question.tags = [];
    Ks.question.no = 0;
    Ks.question.noCurrent = 0;
    Ks.question.idQuestionBtns = [];
    Ks.question.getQuestions();
};

Ks.question.handler = function () {
    $("#selectTagSearch").change(function () {
        getByTag()
    });

    $("#addQuestionBtn").click(function () {
        Ks.question.addNewQuestion();
    });

    $("#showAddQuestionDialog").click(function () {
        Ks.question.initCreateQuestion([]);
        $("#createQuestionDialog").modal();
    });

    $("#saveQuestion").click(function () {
        Ks.question.addQuestion();
    });
};

Ks.question.convertQuestion = function (question) {
    var questionResult = {};
    questionResult.question = question.questiontext;
    questionResult.id = question.id;
    var answers = question.options.answers;
    var wrongAnswer = [];
    var keys = Object.keys(answers);


    if(keys.length > 0){
        questionResult.answer = answers[keys[0]].answer;
    }

    for(var i = 1; i < keys.length; i++) {
        wrongAnswer.push(answers[keys[i]].answer);
    }
    questionResult.wrongAnswer = wrongAnswer;

    questionResult.tags = question.tags;
    return questionResult;
};

// Add new question dilog
Ks.question.addNewQuestion = function(){
    Ks.question.saveQuestionLocal();

    var question = {};
    question.question = "";
    question.answer = "";
    var wrongAnswer = ["", "", ""];
    question.wrongAnswer = wrongAnswer;

    Ks.question.questions[Ks.question.no] = question;
    Ks.question.no++;

    Ks.question.genQuestions(Ks.question.questions);
};

Ks.question.getQuestions = function () {
    if(Object.keys(Ks.question.questions).length == 0){
        Ks.question.addNewQuestion();
    }else {
        Ks.question.genQuestions(Ks.question.questions);
    }
};

Ks.question.genQuestions = function (questions) {
    $("#listQuestionTable").html("");
    Ks.question.idQuestionBtns = [];
    var keys = Object.keys(questions);
    for(var i=0; i < keys.length; i++){
        var html = "";
        var idQuestionBtn = new Date().getTime() + i;
        html += "<li  role='presentation' class='brand-nav' id-question='" + keys[i] + "' id='" + idQuestionBtn + "' tyle='height: 30px;'>";
        html += "<a role='tab' data-toggle='tab'>Question " + (i + 1) + "</a>";
        html += "</li>";
        $("#listQuestionTable").append(html);
        Ks.question.idQuestionBtns.push(idQuestionBtn);
        $("#" + idQuestionBtn).click(function (e){
            Ks.question.saveQuestionLocal();
            var question = Ks.question.questions[$(this).attr("id-question")];
            Ks.question.genQuestion(question, $(this).attr("id-question"));
        });
        if(i == (keys.length - 1)){
            $("#" + idQuestionBtn).addClass("active");
        }
    }

    if(keys.length > 0){
        Ks.question.genQuestion(questions[keys[keys.length - 1]], keys[keys.length - 1]);
    }
};

Ks.question.saveQuestionLocal = function () {
    var question = {};
    question.id = $("#questionId").val();
    question.question = $("#questionTxt").val();
    question.answer = $("#answerTxt").val();
    question.qtype = "multichoice";
    var wrongAnswer = [];
    question.tags = $("#selectTag").val();
    for(var i = 0; i < Ks.question.numberWrongAnswer; i ++){
        wrongAnswer[i] = $("#wrongAnserTxt" + i).val();
    }

    question.wrongAnswer = wrongAnswer;
    Ks.question.questions[Ks.question.noCurrent] = question;
};

Ks.question.genQuestion = function (question, no) {

    Ks.question.noCurrent = no;
    $("#createQuestionErrorText").html("");
    $("#createQuestionErrorText").css("display", "none");
    var html = "";
    html += "<div class='form-group' style='display: none'> "
        + "<input class='form-control' placeholder='question' id='questionId' value='" + question.id + "'> </div>";
    html += "<div class='form-group'> <label for='questionTxt'>Question</label>"
        + "<input style='width: 95%'class='form-control' placeholder='question' id='questionTxt' value='" + question.question + "'> </div>";

    html += "<div class='form-group'> <label for='answerTxt'>Answer</label> <input style='width: 95%' class='form-control' placeholder='answer' id='answerTxt' value='" + question.answer + "'> </div>";

    $("#questionDiv").html(html);
    for(var i = 0; i < question.wrongAnswer.length; i++){
        var idDelWrongAnswer = "idDWA" + new Date().getTime() + i;
        var htmlWrongAnswer = "<div class='form-group'> <label for='answerTxt'>Wrong Answer</label> "
            +" <input style='display: inline-block; width: 95%' class='form-control' placeholder='answer' id='"+ Ks.question.wrongAnswerInputId + i +"' value='" + question.wrongAnswer[i] + "'>"
            // + "<span stt-answer='" + i + "' id='" + idDelWrongAnswer + "' style='display: inline-block; width: 5%' class='glyphicon glyphicon-remove'></span> "
            +" </div>";
        $("#questionDiv").append(htmlWrongAnswer);
        $("#" + idDelWrongAnswer).click(function () {
            // var stt = $(this).attr("stt-answer");
            // var wrongAnswers = Ks.question.currentQuestion.options.answers;
            // var wrongAnswerKeys = Object.keys(wrongAnswers);
            // delete Ks.question.currentQuestion.options.answers[wrongAnswerKeys[stt]];
            // Ks.question.genQuestion(Ks.question.currentQuestion);
        });

    }

    $("#selectTag").val(question.tags).trigger("change");

    Ks.question.activeQuestion(Ks.question.idQuestionBtns[no]);
    Ks.question.numberWrongAnswer = question.wrongAnswer.length;
};

Ks.question.addQuestion = function () {
    Ks.question.saveQuestionLocal();
    var data = {"questions" : JSON.stringify(Ks.question.questions)};

    $.post({url: "/moodle/koolsoft/question/rest/index.php?action=create"
        , data : data
        , success: function(result){
            var questions = JSON.parse(result);
            var keys = Object.keys(questions);
            for(var i=0; i < keys.length; i++){
                var question = questions[keys[i]];
                if(question.resultText != "Success"){
                    Ks.question.genQuestion(question, i);
                    $("#createQuestionErrorText").html(question.resultText);
                    $("#createQuestionErrorText").css("display", "block");
                    return;
                }
            }

            $("#createQuestionDialog").modal('hide');

            getByTag();
        }
    });
};


Ks.question.activeQuestion = function (activeId) {
    for(var i= 0; i < Ks.question.idQuestionBtns.length; i++){
        if(activeId == Ks.question.idQuestionBtns[i]){
            $("#" + Ks.question.idQuestionBtns[i]).addClass("active");
        }else {
            $("#" + Ks.question.idQuestionBtns[i]).removeClass("active");
        }
    }
};

// edit question dilog

$(function () {
    Ks.question.init();
});