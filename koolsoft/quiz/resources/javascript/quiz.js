/**
 * Created by dddd on 12/22/16.
 */
var Ks = Ks || {};
Ks.quiz = Ks.quiz || {};
Ks.quiz.numberQuestionInBank = 0;
Ks.quiz.numberQuestion = 0;
Ks.quiz.questionCurrentIndex = 0;
Ks.quiz.questions = [];
Ks.quiz.numberWrongAnswer = 3;
Ks.quiz.wrongAnswerInputId = "wrongAnserTxt";
Ks.quiz.init = function () {
    Ks.quiz.loadLecture();
    $('#datetimepickerStart').datetimepicker();
    $('#datetimepickerEnd').datetimepicker();

    $.ajax({url: "/moodle/koolsoft/question_tag/rest/question_tag.php?action=listAll",
        success: function(results){
            var tags = JSON.parse(results);
            var keys = Object.keys(tags);
            var tagSelects = [];
            for(var i = 0 ;  i < keys.length; i ++ ){
                var tag = {};
                tag.id = tags[keys[i]].id;
                tag.text = tags[keys[i]].name;
                tagSelects.push(tag);
            }

            $("#selectTagSearch").select2({
                data: tagSelects,
                tags: true,
                tokenSeparators: [',', ' ']
            });

            $("#selectTagCreateQuestion").select2({
                data: tagSelects,
                tags: true,
                tokenSeparators: [',', ' ']
            });
        },
        error: function () {
            console.log("get tag error !!!!!");
        }
    });

    $('#createQuizDialog').on('shown.bs.modal', function() {
        Ks.quiz.clearDialog();
        var idQuiz = $("#idQuiz").val();
        if(idQuiz){
            Ks.quiz.loadQuiz(idQuiz);
        }
    });

};

Ks.quiz.clearDialog = function () {
    $("#listQuestion").html("");
    Ks.quiz.numberQuestionInBank = 0;
    Ks.quiz.numberQuestion = 0;
    Ks.quiz.questions = [];
    Ks.quiz.questionDeletes = [];
    Ks.quiz.clearQuestionDetailView();
    $("#nameQuiz").val("");
    $("#descQuiz").val("");
    $('#datetimepickerStart').data("DateTimePicker").date(null);
    $('#datetimepickerEnd').data("DateTimePicker").date(null);

    $('#chapterSelect option')[0].selected = true;
    $('#lectureSelect').html("");

};

Ks.quiz.handler = function () {
    $("#chapterSelect").change(function(){
        Ks.quiz.loadLecture();
    });

    $("#startTimeText").change(function(){
        var date = new Date($(this).val());
        if(date){
            $("#startTime").val(date.getTime());
        }else {
            $("#startTime").val(0);
        }
    });

    $("#endTimeText").change(function(){
        var date = new Date($(this).val());
        if(date){
            $("#endTime").val(date.getTime());
        }else {
            $("#endTime").val(0);
        }
    });


    $("#removeOneQuestionBtn").click(function(){
        var index = $("#questionIndex").val();
        Ks.quiz.deleteOneQuestion(index);

    });

    $("#btnAddQuestionNew").click(function() {
        var question = {};
        question.question = "";
        question.answer = "";
        var wrongAnswer = [];
        wrongAnswer.push("");
        wrongAnswer.push("");
        wrongAnswer.push("");

        question.wrongAnswer = wrongAnswer;

        Ks.quiz.questions.push(question);
        Ks.quiz.numberQuestion = Ks.quiz.questions.length;
        Ks.quiz.genQuestionTitle();
    });

    $("#btnAddQuestion").click(function(){
        $("#questionBankDialog").modal();
    });

    $("#btnAddQuestionInBank").click(function(){
        var questionExittingName = [];
        var questionIds = [];
        for(var i=0; i < Ks.quiz.numberQuestionInBank; i++){
            if($("#idCheckBoxQuestionBank" + i).prop("checked")){
                var questionId = $("#idCheckBoxQuestionBank" + i).attr("idquestion");
                var questionName = $("#idCheckBoxQuestionBank" + i).attr("namequestion");

                var check = false;
                for(var j =0; j < Ks.quiz.questions.length; j++){
                    if(Ks.quiz.questions[j].id == questionId){
                        check = true;
                    }
                }
                if(check){
                    questionExittingName.push(questionName);
                }else {
                    questionIds.push(questionId);
                }
            }
        }

        if(questionExittingName && questionExittingName.length > 0){
            $("#alertDialog").modal();
            $("#alertContent").html("Some question exitting in quiz: " + questionExittingName.toString());
        }

        if(questionIds.length > 0){
            var data = {};
            data.action = "listByIds";
            data.id = JSON.stringify(questionIds);
            $.ajax({url: "/moodle/koolsoft/question/rest/question.php?",
                data: data,
                success: function(results){
                    var questions = JSON.parse(results);
                    for(var i =0; i < questions.length; i++){
                        Ks.quiz.questions.push(Ks.quiz.convertQuestion(questions[i]));
                    }
                    Ks.quiz.genQuestionTitle();
                    $("#questionBankDialog").modal('hide');

                },
                error: function () {
                    console.log("load question error !");
                }
            });
        }

    });

    $("#saveOneQuestionBtn").click(function(){
        var question = {};
        var indexQuestion = $("#questionIndex").val();
        question.id = $("#questionId").val();
        question.question = $("#questionTxt").val();
        question.answer = $("#answerTxt").val();
        question.qtype = "multichoice";
        var wrongAnswer = [];
        question.tags = $("#selectTagCreateQuestion").val();
        for(var i = 0; i < Ks.quiz.numberWrongAnswer; i ++){
            wrongAnswer[i] = $("#" + Ks.quiz.wrongAnswerInputId + i).val();
        }

        question.wrongAnswer = wrongAnswer;

        var questions = [];
        questions.push(question);

        var data = {"questions" : JSON.stringify(questions)};
        $.post({url: "/moodle/koolsoft/question/rest/question.php?action=create"
            , data : data
            , success: function(result){
                var questions = JSON.parse(result);
                var keys = Object.keys(questions);
                var question = questions[keys[0]];
                console.log(question);
                if(question.resultText != "Success"){
                    $("#createQuestionErrorText").html(question.resultText);
                    $("#createQuestionErrorText").css("display", "block");
                    return;
                }else {
                    Ks.quiz.questions[indexQuestion] = question;
                    window.alert("save question success !");
                }
            }
        });
    });

    $("#saveQuiz").click(function (e) {
        e.preventDefault();
        var questionIds = [];
        var questionNews = [];
        for(var i = 0; i < Ks.quiz.questions.length; i++){
            var question = Ks.quiz.questions[i];
            question.index = i;
            if(!question.id){
                questionNews[i] = question;
            }else {
                questionIds.push(question.id);
            }
        }

        var data = {"questions" : JSON.stringify(questionNews)};
        $.post({url: "/moodle/koolsoft/question/rest/question.php?action=create"
            , data : data
            , success: function(result){
                var questions = JSON.parse(result);
                var keys = Object.keys(questions);
                for(var i = 0; i < keys.length ; i++){
                    var question = questions[keys[i]];
                    if(question.resultText != "Success"){
                        Ks.quiz.genDetailQuestion(question, question.index);
                        $("#createQuestionErrorText").html(question.resultText);
                        $("#createQuestionErrorText").css("display", "block");
                        return;
                    }
                }

                for(var i = 0; i < keys.length ; i++) {
                    var question = questions[keys[i]];
                    questionIds.push(question.id);
                }

                $("#idQuestions").val(questionIds.toString());
                $("#formQuiz").submit();
            }
        });
    });

    $("#selectTagSearch").change(function(){
        Ks.quiz.loadQuestionByTag();
    });

    $("#idCheckBoxQuestionBankAll").change(function(){
        for(var i=0; i < Ks.quiz.numberQuestionInBank; i++){
            $("#idCheckBoxQuestionBank" + i).prop('checked', $("#idCheckBoxQuestionBankAll").prop("checked"));
        }
    });
    $("#idCheckBoxQuestionAll").change(function(){
        for(var i=0; i < Ks.quiz.numberQuestion; i++){
            $("#idCheckBoxQuestion" + i).prop('checked', $("#idCheckBoxQuestionAll").prop("checked"));
        }
    });
};

Ks.quiz.loadQuiz= function (quizId) {
    var data = {};
    data.action = "loadQuiz";
    data.quizId = quizId;
    $.ajax({url: "/moodle/koolsoft/quiz/rest/quiz_rest.php",
        data : data,
        success: function(quiz){
            console.log(quiz);
            $("#nameQuiz").val(quiz.name);
            $("#descQuiz").val(quiz.intro);

            $('#startTime').val(quiz.timeopen);
            $('#endTime').val(quiz.timeclose);

            //load chapter and lecture
            var data= {};
            data.action = "listSectionEqualParent";
            data.idSection = $("#idSection").val();
            $.ajax({url: "/moodle/koolsoft/course/rest/course.php",
                data: data,
                success: function(results){
                    $("#lectureSelect").html("");
                    var sections = JSON.parse(results);
                    var keys = Object.keys(sections);
                    var htmlSelect = "";
                    for(var i = 0; i < keys.length; i++){
                        htmlSelect += "<option value='" + sections[keys[i]].id + "'> " + sections[keys[i]].name + "</option>";
                    }
                    $("#lectureSelect").html(htmlSelect);

                    $("#lectureSelect").val($("#idSection").val());
                },
                error: function () {
                    $("#lectureSelect").html("");
                    console.log("get lecture error !!!!!");
                }
            });

            var questions = quiz.questions;
            Ks.quiz.questions = [];
            for(var i = 0; i < questions.length; i++){
                var question = questions[i];
                Ks.quiz.questions.push(Ks.quiz.convertQuestion(question));
            }

            Ks.quiz.genQuestionTitle();

        },
        error: function () {
            console.log("load quiz error !");
        }
    });
};

Ks.quiz.genQuestionTitle = function () {
    $("#listQuestion").html("");
    var idQuestions = [];
    for(var i=0; i < Ks.quiz.questions.length; i++){
        var html = "";
        var idQuestionBtn = new Date().getTime() + i;
        html += "<li  role='presentation' class='brand-nav' index-question='"+ i +"' id-question='" + Ks.quiz.questions[i].id + "' id='" + idQuestionBtn + "' tyle='height: 30px;'>";
        html += "<a role='tab' data-toggle='tab'>Question " + (i + 1) + "</a>";
        html += "</li>";
        $("#listQuestion").append(html);
        $("#" + idQuestionBtn).click(function (e){
            Ks.quiz.genDetailQuestion(Ks.quiz.questions[$(this).attr("index-question")], $(this).attr("index-question"));
        });
        if(i == (Ks.quiz.questions.length - 1)){
            $("#" + idQuestionBtn).addClass("active");
        }

        if(!Ks.quiz.questions[i].slotid){
            idQuestions.push(Ks.quiz.questions[i].id);
        }
    }

    Ks.quiz.numberQuestion = Ks.quiz.questions.length;
    $("#idQuestions").val(idQuestions.toString());
    if(Ks.quiz.questions.length > 0){
        Ks.quiz.genDetailQuestion(Ks.quiz.questions[Ks.quiz.questions.length - 1], Ks.quiz.questions.length - 1);
    }else {
        Ks.quiz.clearQuestionDetailView();
    }
};

Ks.quiz.genDetailQuestion = function (question, index) {
    $("#createQuestionErrorText").html("");
    $("#createQuestionErrorText").css("display", "none");
    Ks.quiz.currentQuestion = question;
    var html = "";
    html += "<div class='form-group' style='display: none'> "
        + "<input ";
    if(question.id){
        html +="disabled ";
    }
    html += "class='form-control' placeholder='question' id='questionId' value='" + question.id + "'> </div>";
    html += "<div class='form-group' style='display: none'> "
        + "<input class='form-control' placeholder='question' id='questionIndex' value='" + index + "'> </div>";
    html += "<div class='form-group'> <label for='questionTxt'>Question</label>"
        + "<input ";
    if(question.id){
        html +="disabled ";
    }
    html += "style='width: 100%'class='form-control' placeholder='question' id='questionTxt' value='" + question.question + "'> </div>";
    html += "<div class='form-group'> <label for='answerTxt'>Answer</label> <input";

    if(question.id){
        html += " disabled ";
    }
    html += " style='width: 100%' class='form-control' placeholder='answer' id='answerTxt' value='" + question.answer + "'> </div>";
    $("#questionDiv").html(html);

    var wrongAnswer = question.wrongAnswer;
    for(var i = 0; i < wrongAnswer.length; i++){
        var idDelWrongAnswer = "idDWA" + new Date().getTime() + i;
        var htmlWrongAnswer = "<div class='form-group'> <label for='answerTxt'>Wrong Answer</label> "
            +" <input ";
        if(question.id){
            htmlWrongAnswer +="disabled ";
        }
        htmlWrongAnswer += " style='display: inline-block; width: 100%' class='form-control' placeholder='answer' id='"+ Ks.quiz.wrongAnswerInputId + i +"' value='" + wrongAnswer[i] + "'>"
            // + "<span stt-answer='" + i + "' id='" + idDelWrongAnswer + "' style='display: inline-block; width: 5%' class='glyphicon glyphicon-remove'></span> "
            +" </div>";
        $("#questionDiv").append(htmlWrongAnswer);
        $("#" + idDelWrongAnswer).click(function () {
            var stt = $(this).attr("stt-answer");
            var wrongAnswers = Ks.quiz.currentQuestion.options.answers;
            var wrongAnswerKeys = Object.keys(wrongAnswers);
            delete Ks.quiz.currentQuestion.options.answers[wrongAnswerKeys[stt]];
            Ks.quiz.genDetailQuestion(Ks.question.currentQuestion);
        });
    }

    $("#selectTagCreateQuestion").val(question.tags).trigger("change");
    $("#selectTagCreateQuestionDiv").css("display", "block");
    $("#removeOneQuestionBtn").css("display", "inline-block");
    if(question.id){
        $("#saveOneQuestionBtn").css("display", "none");
        $('#selectTagCreateQuestion').select2("enable", false);
    }else {
        $("#saveOneQuestionBtn").css("display", "inline-block");
        $('#selectTagCreateQuestion').select2("enable");
    }

};


Ks.quiz.deleteOneQuestion = function (index) {
    Ks.quiz.questions.splice(index, index + 1);
    Ks.quiz.clearQuestionDetailView();
    Ks.quiz.genQuestionTitle();
};

Ks.quiz.clearQuestionDetailView = function (){
    $("#questionDiv").html("");
    $("#selectTagCreateQuestionDiv").css("display", "none");
    $("#createQuestionErrorText").css("display", "none");
    $("#saveOneQuestionBtn").css("display", "none");
    $("#removeOneQuestionBtn").css("display", "none");
};

Ks.quiz.loadQuestionByTag = function () {
    var tag = $("#selectTagSearch").val();
    var data = {};
    data.tag = JSON.stringify(tag);
    data.action = "listByTag";
    $.ajax({url: "/moodle/koolsoft/question/rest/question.php",
        data: data,
        success: function(results){
            var questions = JSON.parse(results);
            var keys = Object.keys(questions);
            var htmlTr = "";
            for(var i = 0; i < keys.length; i++){
                if(questions[keys[i]].id){
                    htmlTr += "<tr>"
                        + "<td><input type='checkbox' value='' id='idCheckBoxQuestionBank"+ i + "' idQuestion='"+ questions[keys[i]].id + "' nameQuestion='"+ questions[keys[i]].name + "'></td>"
                        + "<td>" + questions[keys[i]].name + "</td>"
                        +"</tr>";
                }
            }

            Ks.quiz.numberQuestionInBank = keys.length;
            $("#bodyTableQuestionBank").html(htmlTr);
        },
        error: function () {
            console.log("get question error !!!!!");
        }
    });
};

Ks.quiz.loadLecture = function () {
    var data= {};
    data.action = "listSectionChild";
    data.idParent = $("#chapterSelect").val();
    $.ajax({url: "/moodle/koolsoft/course/rest/course.php",
        data: data,
        success: function(results){
            $("#lectureSelect").html("");
            var sections = JSON.parse(results);
            var keys = Object.keys(sections);
            var htmlSelect = "";
            for(var i = 0; i < keys.length; i++){
                htmlSelect += "<option value='" + sections[keys[i]].id + "'> " + sections[keys[i]].name + "</option>";
            }
            $("#lectureSelect").html(htmlSelect);

        },
        error: function () {
            $("#lectureSelect").html("");
            console.log("get lecture error !!!!!");
        }
    });
};

Ks.quiz.convertQuestion = function (question) {
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

$(function () {
    $(".editQuizBtn").click(function () {
        var idQuiz = $(this).attr("id-quiz");
        $("#idQuiz").val(idQuiz);
        var idSection = $(this).attr("id-section");
        $("#idSection").val(idSection);
        $("#createQuizDialog").modal();
    });

    $(".createQuizBtn").click(function () {
        $("#idQuiz").val("");
        $("#createQuizDialog").modal();
    });
    Ks.quiz.init();
    Ks.quiz.handler();

});