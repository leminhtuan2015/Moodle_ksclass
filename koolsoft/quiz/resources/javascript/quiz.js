/**
 * Created by dddd on 12/22/16.
 */
var Ks = Ks || {};
Ks.quiz = Ks.quiz || {};
Ks.quiz.numberQuestionInBank = 0;
Ks.quiz.numberQuestion = 0;
Ks.quiz.questions = [];
Ks.quiz.questionDeletes = [];
Ks.quiz.wrongAnswerInputId = "wrongAnserTxt";
Ks.quiz.init = function () {
    Ks.quiz.getSlotForQuiz();
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
        },
        error: function () {
            console.log("get tag error !!!!!");
        }
    });

    $('#createQuizDialog').on('shown.bs.modal', function() {
        Ks.quiz.clearDialog();
    });

};

Ks.quiz.clearDialog = function () {
    $("#listQuestion").html("");
    Ks.quiz.numberQuestionInBank = 0;
    Ks.quiz.numberQuestion = 0;
    Ks.quiz.questions = [];
    Ks.quiz.questionDeletes = [];
    $("#nameQuiz").html("");
    $("#nameQuiz").html("");
    $("#startTimeText").html("");
    $("#endTimeText").html("");
    $("#startTime").html("");
    $("#endTime").html("");
};

Ks.quiz.renderQuestion = function () {
    var htmlTr = "";
    var idQuestions = [];
    for(var i =0; i < Ks.quiz.questions.length; i++){
        htmlTr += "<tr>"
            + "<td><input type='checkbox' value='' id='idCheckBoxQuestion"+ i + "' idQuestion='"+ Ks.quiz.questions[i].id + "' slotId='"+ Ks.quiz.questions[i].slotid + "'> </td>"
            + "<td>"+(i+1)+"</td>"
            + "<td>" + Ks.quiz.questions[i].name + "</td>"
            +"</tr>";
        var idGeneral = new Date().getTime() + "" + Ks.quiz.questions[i].id;
        if(!Ks.quiz.questions[i].slotid){
            idQuestions.push(Ks.quiz.questions[i].id);
        }
    }
    Ks.quiz.numberQuestion = Ks.quiz.questions.length;
    $("#idQuestions").val(idQuestions.toString());
    $("#bodyTableQuestion").html(htmlTr);
};

Ks.quiz.renderQuestion2 = function (questionDeletes) {
    Ks.quiz.questions = questionDeletes;
    var htmlTr = "";
    var idQuestions = [];
    for(var i =0; i < questionDeletes.length; i++){
        htmlTr += "<tr>"
            + "<td><input type='checkbox' value='' id='idCheckBoxQuestion"+ i + "' idQuestion='"+ questionDeletes[i].id + "' slotId='"+ questionDeletes[i].slotid + "'> </td>"
            + "<td>"+(i+1)+"</td>"
            + "<td>" + questionDeletes[i].name + "</td>"
            +"</tr>";
        var idGeneral = new Date().getTime() + "" + questionDeletes[i].id;
        if(!questionDeletes[i].slotid){
            idQuestions.push(questionDeletes[i].id);
        }
    }
    Ks.quiz.numberQuestion = questionDeletes.length;
    $("#idQuestions").val(idQuestions.toString());
    $("#bodyTableQuestion").html(htmlTr);
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

    $("#btnAddQuestion").click(function(){
        $("#questionBankDialog").modal();
    });

    $("#btnAddQuestionInBank").click(function(){
        var questionExitting = [];
        for(var i=0; i < Ks.quiz.numberQuestionInBank; i++){
            if($("#idCheckBoxQuestionBank" + i).prop("checked")){
                var questionId = $("#idCheckBoxQuestionBank" + i).attr("idquestion");
                var questionName = $("#idCheckBoxQuestionBank" + i).attr("namequestion");
                var questionObject = {};
                questionObject.id = questionId;
                questionObject.name = questionName;
                var check = false;
                for(var i =0; i < Ks.quiz.questions.length; i++){
                    if(Ks.quiz.questions[i].id == questionObject.id){
                        check = true;
                    }
                }
                if(!check){
                    Ks.quiz.questions.push(questionObject);
                }else {
                    questionExitting.push(questionObject.name);
                }
            }
        }
        if(questionExitting && questionExitting.length > 0){
            $("#alertDialog").modal();
            $("#alertContent").html("Some question exitting in quiz: " + questionExitting.toString());
        }
        Ks.quiz.genQuestions();
        $("#questionBankDialog").modal('hide');
    });

    $("#btnDeleteQuestion").click(function(){
        var questionNoDeletes = [];
        for(var i=0; i < Ks.quiz.questions.length; i++){
            if(!$("#idCheckBoxQuestion" + i).prop("checked")){
                var question = {};
                question.id = Ks.quiz.questions[i].id;
                question.name = Ks.quiz.questions[i].name;
                question.slotid = Ks.quiz.questions[i].slotid;
                questionNoDeletes.push(question);
            }else {
                if($("#idCheckBoxQuestion" + i).attr("slotid")){
                    Ks.quiz.questionDeletes.push($("#idCheckBoxQuestion" + i).attr("slotid"));
                    $("#idSlotRemoves").val(Ks.quiz.questionDeletes.toString());
                }
            }
        }
        if(questionNoDeletes.length == Ks.quiz.numberQuestion){
            $("#alertDialog").modal();
            $("#alertContent").html("You must choice question to delete!");
        }else {
            Ks.quiz.renderQuestion2(questionNoDeletes);
        }
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

Ks.quiz.getSlotForQuiz= function () {
    var quizId = $("#idQuiz").val();
    if(quizId){
        $.ajax({url: "/moodle/koolsoft/quiz/rest/quiz_rest.php?quizId=" + quizId, success: function(slots){
            var keys = Object.keys(slots);
            for(var i = 0; i < keys.length; i++){
                var question = {};
                question.id = slots[keys[i]].id;
                question.name = slots[keys[i]].name;
                question.slotid = slots[keys[i]].slotid;
                question.maxmark = slots[keys[i]].maxmark;
                Ks.quiz.questions.push(question);
            }
            Ks.quiz.genQuestions(Ks.quiz.questions);
        }});
    }
};

Ks.quiz.genQuestions = function () {
    $("#listQuestion").html("");
    var idQuestions = [];
    for(var i=0; i < Ks.quiz.questions.length; i++){
        var html = "";
        var idQuestionBtn = new Date().getTime() + i;
        html += "<li  role='presentation' class='brand-nav' id-question='" + Ks.quiz.questions[i].id + "' id='" + idQuestionBtn + "' tyle='height: 30px;'>";
        html += "<a role='tab' data-toggle='tab'>Question " + (i + 1) + "</a>";
        html += "</li>";
        $("#listQuestion").append(html);
        $("#" + idQuestionBtn).click(function (e){
            $.ajax({url: "/moodle/koolsoft/question/rest/question.php?action=one&id=" + $(this).attr("id-question"), success: function(result){
                Ks.quiz.genQuestion(JSON.parse(result));
            }});
        });
        // if(i == (Ks.quiz.questions.length - 1)){
        //     $("#" + idQuestionBtn).addClass("active");
        // }

        if(!Ks.quiz.questions[i].slotid){
            idQuestions.push(Ks.quiz.questions[i].id);
        }
    }

    Ks.quiz.numberQuestion = Ks.quiz.questions.length;
    $("#idQuestions").val(idQuestions.toString());
    // if(Ks.quiz.questions.length > 0){
    //     Ks.question.genQuestion(Ks.question.questions[Ks.question.questions.length - 1]);
    // }
};

Ks.quiz.genQuestion = function (question) {
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
    html += "<div class='form-group'> <label for='questionTxt'>Question</label>"
        + "<input ";
    if(question.id){
        html +="disabled ";
    }
    html += "style='width: 100%'class='form-control' placeholder='question' id='questionTxt' value='" + question.questiontext + "'> </div>";
    var answers = question.options.answers;
    var keys = Object.keys(answers);


    if(keys.length > 0){
        html += "<div class='form-group'> <label for='answerTxt'>Answer</label> <input";
        if(question.id){
            html += " disabled ";
        }
        html += " style='width: 100%' class='form-control' placeholder='answer' id='answerTxt' value='" + answers[keys[0]].answer + "'> </div>";
    }

    $("#questionDiv").html(html);
    for(var i = 1; i < keys.length; i++){
        var idDelWrongAnswer = "idDWA" + new Date().getTime() + i;
        var htmlWrongAnswer = "<div class='form-group'> <label for='answerTxt'>Wrong Answer</label> "
            +" <input ";
        if(question.id){
            htmlWrongAnswer +="disabled ";
        }
        htmlWrongAnswer += " style='display: inline-block; width: 100%' class='form-control' placeholder='answer' id='"+ Ks.quiz.wrongAnswerInputId + (i - 1) +"' value='" + answers[keys[i]].answer + "'>"
            // + "<span stt-answer='" + i + "' id='" + idDelWrongAnswer + "' style='display: inline-block; width: 5%' class='glyphicon glyphicon-remove'></span> "
            +" </div>";
        $("#questionDiv").append(htmlWrongAnswer);
        // $("#" + idDelWrongAnswer).click(function () {
        //     var stt = $(this).attr("stt-answer");
        //     var wrongAnswers = Ks.quiz.currentQuestion.options.answers;
        //     var wrongAnswerKeys = Object.keys(wrongAnswers);
        //     delete Ks.quiz.currentQuestion.options.answers[wrongAnswerKeys[stt]];
        //     Ks.quiz.genQuestion(Ks.question.currentQuestion);
        // });
    }

    // Ks.question.numberWrongAnswer = keys.length - 1;
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
            $("#bodyTableQuestionBank").html(htmlTr);
            Ks.quiz.numberQuestionInBank = keys.length;
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
                htmlSelect += "<option value='" + sections[keys[i]].section + "'> " + sections[keys[i]].name + "</option>";
            }
            $("#lectureSelect").html(htmlSelect);

        },
        error: function () {
            $("#lectureSelect").html("");
            console.log("get lecture error !!!!!");
        }
    });
};

$(function () {

    Ks.quiz.init();
    Ks.quiz.handler();

});