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
    Ks.question.loadQuestionByTag();
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

Ks.question.loadQuestionByTag = function () {
    return; //STUPID
    var tag = $("#selectTagSearch").val();
    var data = {};
    data.tag = JSON.stringify(tag);
    data.action = "listByTag";
    $.ajax({url: "/moodle/koolsoft/question/rest/index.php/",
        data: data,
        success: function(results){
            var questions = JSON.parse(results);
            var keys = Object.keys(questions);
            $("#idBodyTableQuestion").html("");
            Ks.question.numberQuestion = keys.length;
            for(var i= 0; i < keys.length; i++){
                var question = questions[keys[i]];
                if(question.id){
                    var idEdit = "edit" + new Date().getTime() + question.id;
                    var idDelete = "del" + new Date().getTime() + question.id;
                    var idCheckBox = Ks.question.checkboxQuestionId + i;
                    var html = "";
                    html += "<tr style='height: 50px;'>";
                    html += "<td> " + (i + 1) + "</td>";
                    html += "<td>";
                    html += question.name;
                    html += "</td>";
                    html += "<td>";
                    html += question.timemodified;
                    html += "</td>";
                    html += "<td>";
                    html += "<div class='dropdown' style='display: inline-block; float: right;'>"
                        + "<button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>"
                        + "<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>"
                        + "</button>"
                        + "<ul class='dropdown-menu'>"
                        + "<li id='" + idEdit + "' question-id='" + question.id + "' question-name='" + question.name + "'> <a> Edit </a> </li>"
                        + "<li id='" + idDelete + "'question-id='" + question.id + "'> <a >Delete</a></li>"
                        + "</ul> </div>";
                    html += "</td>";
                    html += "<td>";
                    html += "<input type='checkbox'"+ " question-id='" + question.id +"' id='" + idCheckBox + "'  value=''>";
                    html += "</td>";

                    $("#idBodyTableQuestion").append(html);


                    $("#" + idDelete).click(function () {
                        $("#idObjectDelete").val($(this).attr("question-id"));
                        $("#confirmDialogDelete").modal();
                    });

                    $("#" + idEdit).click(function () {
                        var id = $(this).attr("question-id");
                        var data = {};
                        data.action = "one";
                        data.id = id;
                        $.ajax({url: "/moodle/koolsoft/question/rest/question.php",
                            data: data,
                            success: function(result){
                                var question = Ks.question.convertQuestion(JSON.parse(result));
                                $("#questionEditId").val(question.id);
                                $("#questionEditTxt").val(question.question);
                                $("#answerEditTxt").val(question.answer);

                                for(var i = 0; i < question.wrongAnswer.length; i++){
                                    $("#wrongAnserEditTxt" + i).val(question.wrongAnswer[i]);
                                }

                                $("#selectTagEditQuestion").val(question.tags).trigger("change");
                                $("#editQuestionDialog").modal();
                                $("#editQuestionErrorText").css("display", "none");
                            },
                            error: function () {
                                console.log("get question error !!!!!");
                            }

                        });
                    });
                }
            }
        },
        error: function () {
            console.log("get question error !!!!!");
        }
    });
};

Ks.question.handler = function () {
    $("#selectTagSearch").change(function () {
        Ks.question.loadQuestionByTag();
    });

    $("#saveEditQuestion").click(function () {
        Ks.question.editQuestion();
    });

    $("#showAddToQuizDialog").click(function () {
        var questionIds= [];
        for(var i = 0; i < Ks.question.numberQuestion; i++){
            if($("#" + Ks.question.checkboxQuestionId + i).prop("checked")){
                var questionId = $("#" + Ks.question.checkboxQuestionId + i).attr("question-id");
                if(questionId){
                    questionIds.push(questionId);
                }
            }
        }
        if(questionIds.length > 0){
            $("#addToQuizDialog").modal();
        }
    });

    $("#showCopyQuestionDialog").click(function () {
        var questionIds= [];
        for(var i = 0; i < Ks.question.numberQuestion; i++){
            if($("#" + Ks.question.checkboxQuestionId + i).prop("checked")){
                var questionId = $("#" + Ks.question.checkboxQuestionId + i).attr("question-id");
                if(questionId){
                    questionIds.push(questionId);
                }
            }
        }
        if(questionIds.length > 0){
            var data = {};
            data.id = JSON.stringify(questionIds);
            data.action = "listByIds";
            $.ajax({url: "/moodle/koolsoft/question/rest/question.php",
                data: data,
                success: function(results){
                    var questions = JSON.parse(results);
                    var questionResults = [];
                    for(var i =0; i < questions.length; i++){
                        var question = Ks.question.convertQuestion(questions[i]);
                        question.id = null;
                        questionResults.push(question);
                    }
                    Ks.question.initCreateQuestion(questionResults);
                    $("#createQuestionDialog").modal();
                },
                error: function () {
                    console.log("get question error !!!!!");
                }
            });
        }

    });

    $("#addQuestionBtn").click(function () {
        Ks.question.addNewQuestion();
    });

    $("#showAddQuestionDialog").click(function () {
        Ks.question.initCreateQuestion([]);
        $("#createQuestionDialog").modal();
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
        data.action = "delete";
        $.post({url: "/moodle/koolsoft/question/rest/question.php",
            data : data,
            success: function(result){
                if(result){
                    $("#confirmDialogDelete").modal('hide');
                    Ks.question.loadQuestionByTag();
                }else {
                    $("#alertDialog").modal();
                    $("#alertContent").html("Can not delete question!");
                }
        }});
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

    alert(JSON.stringify(Ks.question.questions));

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
            Ks.question.loadQuestionByTag();

            getByTag();
        }
    });
};

Ks.question.editQuestion = function () {
    var question = {};
    question.id = $("#questionEditId").val();
    question.question = $("#questionEditTxt").val();
    question.answer = $("#answerEditTxt").val();
    var wrongAnswer = [];
    for(var i = 0; i < 3; i++){
        wrongAnswer[i] = $("#wrongAnserEditTxt" + i).val();
    }

    question.wrongAnswer = wrongAnswer;
    question.tags = $("#selectTagEditQuestion").val();
    question.qtype = "multichoice";

    var questions = [];
    questions.push(question);

    var data = {"questions" : JSON.stringify(questions)};
    $.post({url: "/moodle/koolsoft/question/rest/question.php?action=create"
        , data : data
        , success: function(result){
            var questions = JSON.parse(result);
            var keys = Object.keys(questions);
            for(var i=0; i < keys.length; i++){
                var question = questions[keys[i]];
                if(question.resultText != "Success"){
                    $("#editQuestionErrorText").html(question.resultText);
                    $("#editQuestionErrorText").css("display", "block");
                    return;
                }
            }

            $("#editQuestionDialog").modal('hide');
            Ks.question.loadQuestionByTag();
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