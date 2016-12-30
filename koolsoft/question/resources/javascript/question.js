var Ks = Ks || {};
Ks.question = Ks.question || {};
Ks.question.numberWrongAnswer = 2;
Ks.question.wrongAnswerInputId = "wrongAnserTxt";
Ks.question.currentQuestion = {};
Ks.question.done = false;
Ks.question.questions = [];
Ks.question.questionAdd = null;

Ks.question.init = function () {
    Ks.question.handler();
    Ks.question.getQuestions();
};

Ks.question.handler = function () {
    $("#btnDone").click(function () {
        Ks.question.done = true;
        Ks.question.addQuestion();
    });
    $("#btnEditCategoryName").click(function () {
        $("#inputCategoryName").css("display", "inline-block");
        $("#labelCategoryName").css("display", "none");
        $("#btnEditCategoryName").css("display", "none");
    });

    $("#inputCategoryName").change(function () {

        var idCategory = $("#categoryId").val();
        var nameCategory = $("#inputCategoryName").val();

        var data = {};
        data.action = "create";
        data.id = idCategory;
        data.name = nameCategory;
        $.post({ url: "/moodle/koolsoft/question_categories/rest/question_categories.php",
            data: data,
            success: function(result){
                if(result){
                    var category = JSON.parse(result);
                    if(category.resultText == "Success"){
                        $("#labelCategoryName").val(category.name);
                        $("#labelCategoryName").html(category.name);
                    }else {
                        $("#alertDialog").modal();
                        $("#alertContent").html(category.resultText);
                    }
                    $("#labelCategoryName").css("display", "inline-block");
                    $("#btnEditCategoryName").css("display", "inline-block");
                    $("#inputCategoryName").css("display", "none");
                }
            }
        });

    });

    $("#addWrongAnswerBtn").click(function () {
        Ks.question.numberWrongAnswer ++;
        var idWrongAnswer = Ks.question.wrongAnswerInputId + (Ks.question.numberWrongAnswer - 1);
        var html ="<div class='form-group'> <label for='" + idWrongAnswer
            + "'>Wrong Answer</label> <input class='form-control' placeholder='wrong answer' id='" + idWrongAnswer + "'></div>";
       $("#questionDiv").append(html);
    });

    $("#saveQuestion").click(function () {
        Ks.question.addQuestion();
    });

    $("#deleteQuestionBtn").click(function () {
        $("#idObjectDelete").val(Ks.question.currentQuestion.id);
        $("#confirmDialogDelete").modal();
    });

    $("#btnConfirmDelete").click(function () {
        var data = {};
        data.id = $("#idObjectDelete").val();
        data.qtype = "multichoice";
        $.post({url: "/moodle/koolsoft/question/rest/question.php?action=delete&id=" + Ks.question.currentQuestion.id,
            data : data,
            success: function(result){
                if(result){
                    $("#confirmDialogDelete").modal('hide');
                    Ks.question.getQuestions();
                }else {
                    $("#alertDialog").modal();
                    $("#alertContent").html("Can not delete question!");
                }
        }});
    });

    $("#addQuestionBtn").click(function () {
        Ks.question.addNewFirstQuestion();
    });
};

Ks.question.addNewFirstQuestion = function(){
    var question = {};
    question.question = "question";
    question.answer = "answer";
    var wrongAnswer = ["wrongAnser1", "wrongAnser1"];
    question.wrongAnswer = wrongAnswer;

    $.post({url: "/moodle/koolsoft/question/rest/question.php?action=create&categoryId="+ $("#categoryId").val()
        , data : question
        , success: function(result){
            if(result){
                Ks.question.getQuestions();
            }
        }
    });
};

Ks.question.getQuestions = function () {
    $.ajax({url: "/moodle/koolsoft/question/rest/question.php?action=list&categoryId=" + $("#categoryId").val(), success: function(results){
        var questions = JSON.parse(results);

        if(questions.length == 0){
            Ks.question.addNewFirstQuestion();
        }else {
            Ks.question.genQuestions(questions);
        }
    }});
};

Ks.question.genQuestions = function (questions) {
    $("#listQuestionTable").html("");
    var keys = Object.keys(questions);
    Ks.question.questions = [];
    for(var i=0; i < keys.length; i++){
        var html = "";
        var idQuestionBtn = new Date().getTime() + i;
        html += "<li  role='presentation' class='brand-nav' id-question='" + questions[keys[i]].id + "' id='" + idQuestionBtn + "' tyle='height: 30px;'>";
        html += "<a role='tab' data-toggle='tab'>Question " + (i + 1) + "</a>";
        html += "</li>";
        Ks.question.questions[i] = questions[keys[i]];
        $("#listQuestionTable").append(html);
        question = questions[keys[i]];
        $("#" + idQuestionBtn).click(function (e){
            $.ajax({url: "/moodle/koolsoft/question/rest/question.php?action=one&id=" + $(this).attr("id-question"), success: function(result){
                Ks.question.genQuestion(JSON.parse(result));
            }});
        });
        if(i == (keys.length - 1)){
            $("#" + idQuestionBtn).addClass("active");
        }
    }

    if(Ks.question.questions.length > 0){
        Ks.question.genQuestion(Ks.question.questions[Ks.question.questions.length - 1]);
    }
};

Ks.question.genQuestion = function (question) {
    $("#createQuestionErrorText").html("");
    $("#createQuestionErrorText").css("display", "none");
    Ks.question.currentQuestion = question;
    var html = "";
    html += "<div class='form-group' style='display: none'> "
        + "<input class='form-control' placeholder='question' id='questionId' value='" + question.id + "'> </div>";
    html += "<div class='form-group'> <label for='questionTxt'>Question</label>"
        + "<input style='width: 95%'class='form-control' placeholder='question' id='questionTxt' value='" + question.questiontext + "'> </div>";
    var answers = question.options.answers;
    var keys = Object.keys(answers);


    if(keys.length > 0){
        html += "<div class='form-group'> <label for='answerTxt'>Answer</label> <input style='width: 95%' class='form-control' placeholder='answer' id='answerTxt' value='" + answers[keys[0]].answer + "'> </div>";
    }

    $("#questionDiv").html(html);
    for(var i = 1; i < keys.length; i++){
        var idDelWrongAnswer = "idDWA" + new Date().getTime() + i;
        var htmlWrongAnswer = "<div class='form-group'> <label for='answerTxt'>Wrong Answer</label> "
            +" <input style='display: inline-block; width: 95%' class='form-control' placeholder='answer' id='"+ Ks.question.wrongAnswerInputId + (i - 1) +"' value='" + answers[keys[i]].answer + "'>"
            + "<span stt-answer='" + i + "' id='" + idDelWrongAnswer + "' style='display: inline-block; width: 5%' class='glyphicon glyphicon-remove'></span> "
            +" </div>";
        $("#questionDiv").append(htmlWrongAnswer);
        $("#" + idDelWrongAnswer).click(function () {
            var stt = $(this).attr("stt-answer");
            var wrongAnswers = Ks.question.currentQuestion.options.answers;
            var wrongAnswerKeys = Object.keys(wrongAnswers);
            delete Ks.question.currentQuestion.options.answers[wrongAnswerKeys[stt]];
            Ks.question.genQuestion(Ks.question.currentQuestion);
        });
    }

    Ks.question.numberWrongAnswer = keys.length - 1;
};

Ks.question.addQuestion = function () {
    var question = {};
    question.id = $("#questionId").val();
    question.question = $("#questionTxt").val();
    question.answer = $("#answerTxt").val();
    var wrongAnswer = [];
    for(var i = 0; i < Ks.question.numberWrongAnswer; i ++){
        wrongAnswer[i] = $("#wrongAnserTxt" + i).val();
    }
    question.wrongAnswer = wrongAnswer;
    $.post({url: "/moodle/koolsoft/question/rest/question.php?action=create&categoryId="+ $("#categoryId").val()
        , data : question
        , success: function(result){
            if(result){
                var question = JSON.parse(result);
                if(question.resultText == "Success"){
                    if(Ks.question.done){
                        window.location.href = $("#returnUrl").val();
                    }else {
                        Ks.question.getQuestions();
                        $("#createQuestionErrorText").html("");
                        $("#createQuestionErrorText").css("display", "none");
                    }
                }else {
                    $("#createQuestionErrorText").html(question.resultText);
                    $("#createQuestionErrorText").css("display", "block");
                    Ks.question.done = false;
                }

            }
        }
    });
};

$(function () {
    Ks.question.init();
});