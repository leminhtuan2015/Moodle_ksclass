/**
 * Created by dddd on 1/13/17.
 */

var Ks = Ks || {};
Ks.exercise = Ks.exercise || {};
Ks.exercise.quiz = {};
Ks.exercise.idQuizCurrent = null;
Ks.exercise.idSectionCurrent = null;
Ks.exercise.exercisePanelCurrent = null;
Ks.exercise.questionPanelCurrent = null;
Ks.exercise.questionResult = [];
Ks.exercise.pagination = null;
Ks.exercise.isOwner = false;

Ks.exercise.init = function () {
    Ks.exercise.handler();
};

Ks.exercise.handler = function (idBtnFinishExercise, idBtnNewExercise) {

    addHandle();

    $(".questionNumber").click(function () {
        var divQuestion = $("#" + $(this).attr("id-div"));
        $(".questionDiv").css("display", "none");
        divQuestion.css("display", "inline-block");

        $(".footerQuestionNumber").css("display", "none");
        var footerQuestionNumber = $("#" + $(this).attr("footer-id"));
        footerQuestionNumber.css("display", "block");
    });

    $(".questionExercise").click(function () {
        var index = $(this).attr("index-question");
        var divQuestionNumber = $("#" + $(this).attr("div-question-number"));
        divQuestionNumber.removeClass("questionNoAnswer");
        var nameInput = $(this).attr("name");
        var inputAnswers = $("input[name=" + nameInput + "]");

        for(var i = 0; i < inputAnswers.length; i++){
            var inputAnswer = $(inputAnswers[i]);
            inputAnswer.prop("disabled", true);
            if(inputAnswer.attr("value") == "true"){
                inputAnswer.addClass("questionExerciseCorrect");
            }
        }

        var divResult = $("#" + $(this).attr("div-result"));
        divResult.css("display", "block");
        Ks.exercise.quiz.questions[index - 1].finished = true;
        if($(this).attr("value") == "true"){
            Ks.exercise.quiz.questions[index - 1].fraction = 1;
            $(this).addClass("questionExerciseCorrect");
            divResult.addClass("divCorrect");
            divQuestionNumber.addClass("questionCorrectAnswer");
            divResult.find("#correct").css("display", "block");
            divResult.find("#wrong").css("display", "none");
        }else {
            Ks.exercise.quiz.questions[index - 1].fraction = 0;
            $(this).addClass("questionExerciseWrong");
            divResult.addClass("divWrong");
            divQuestionNumber.addClass("questionWrongAnswer");
            divResult.find("#correct").css("display", "none");
            divResult.find("#wrong").css("display", "block");
        }

        if(Ks.exercise.questionResult.length == Ks.exercise.quiz.questions.length){
            $("#" + idBtnFinishExercise).css("display", "block");
        }
    });

    $(".boxName").change(function () {
        var value = $(this).val();

        if(value == -1){
        	var label = "All question";
            Ks.exercise.genQuestion(label, Ks.exercise.quiz.questions);
        }else if(value == 0){
            var label = "Questions that you answered incorrectly";
            Ks.exercise.genQuestion(label, Ks.exercise.quiz.questionBoxWrong);
        }else if(value == 1){
            var label = "Questions that you answered correctly once";
            Ks.exercise.genQuestion(label, Ks.exercise.quiz.questionBox1);
        }else if(value == 2){
            var label = "Questions that you answered correctly twice";
            Ks.exercise.genQuestion(label, Ks.exercise.quiz.questionBox2);
        }else if(value == 3){
            var label = "Questions that you answered correctly thrice";
            Ks.exercise.genQuestion(label, Ks.exercise.quiz.questionBox3);
        }else if(value == 4){
            var label = "Questions that you already passed";
            Ks.exercise.genQuestion(label, Ks.exercise.quiz.questionBoxN);
        }
    });

    if(idBtnFinishExercise){
        $("." + idBtnFinishExercise).click(function () {
            var dataQuestion = Ks.exercise.getDataSubmit();
            if(dataQuestion){
                var data = {};
                data.action = "play";
                data.questionData = JSON.stringify(dataQuestion);
                data.quiz = Ks.exercise.idQuizCurrent;
                $.ajax({
                    url: "/moodle/koolsoft/exercise/rest",
                    data: data,
                    success: function (result) {
                        var quiz = JSON.parse(result);
                        Ks.exercise.genReviewView(quiz, Ks.exercise.exercisePanelCurrent);
                    }
                });
            }else {
                var index = $(this).attr("index-question") - 1;
                var questions = Ks.exercise.quiz.questions;
                for(var i = 0; i < questions.length; i++){
                    var question = questions[i];
                    if(!question.finished){
                        Ks.exercise.gotoQuestion(i);
                        return;
                    }
                }
            }
        });
    }

    if(idBtnNewExercise){
        $("#" + idBtnNewExercise).click(function () {
            var currentBox = $("input[name=boxName]:checked").val();
            if(!currentBox){
                currentBox = -1;
            }
            if(currentBox == -1){
                if(Ks.exercise.quiz.questions.length == 0){
                    window.alert("Not question to play!");
                    return;
                }
            }else if(currentBox == 0){
                if(Ks.exercise.quiz.questionBoxWrong.length == 0){
                    window.alert("Not question to play!");
                    return;
                }
            }else if(currentBox == 1){
                if(Ks.exercise.quiz.questionBox1.length == 0){
                    window.alert("Not question to play!");
                    return;
                }
            }else if(currentBox == 2){
                if(Ks.exercise.quiz.questionBox2.length == 0){
                    window.alert("Not question to play!");
                    return;
                }
            }else if(currentBox == 3){
                if(Ks.exercise.quiz.questionBox3.length == 0){
                    window.alert("Not question to play!");
                    return;
                }
            }else if(currentBox == 4){
                if(Ks.exercise.quiz.questionBoxN.length == 0){
                    window.alert("Not question to play!");
                    return;
                }
            }

            var data = {};
            data.action = "start";
            data.quiz = Ks.exercise.idQuizCurrent;
            data.box = currentBox;
            $.ajax({
                url: "/moodle/koolsoft/exercise/rest",
                data: data,
                success: function (result) {
                    Ks.exercise.quiz = JSON.parse(result);
                    Ks.exercise.genPlayView(Ks.exercise.quiz, Ks.exercise.exercisePanelCurrent);
                }
            });
        });
    }


};

Ks.exercise.gotoQuestion = function (index){
    var idBtnQuestionNumber = "questionNumber" + Ks.exercise.quiz.questions[index].id;
    $("#" + idBtnQuestionNumber).click();
}

Ks.exercise.getDataSubmit = function (){
    var data = [];
    for(var i = 0; i < Ks.exercise.quiz.questions.length; i ++){
        var question = Ks.exercise.quiz.questions[i];
        if(question.finished){
            data.push({questionId : question.id, fraction : question.fraction});
        }else {
            return null;
        }
    }

    return data;
}

Ks.exercise.genPlayView = function (quiz, questionPanel){
    var idBtnFinishExercise = new Date().getTime() + "FinishExercise";
    var template = $("#templateExercisePlay").html();
    Mustache.parse(template);
    var questionHtml = Mustache.render(template, {isOwner: Ks.exercise.isOwner, quiz : quiz, idBtnFinishExercise : idBtnFinishExercise, sectionId: Ks.exercise.idSectionCurrent, quizId: Ks.exercise.idQuizCurrent});
    questionPanel.html(questionHtml);

    Ks.exercise.handler(idBtnFinishExercise, null);
};

Ks.exercise.genReviewView = function (quiz, reviewPanel){

    var questions = [];
    questions = questions.concat(quiz.questionBoxWrong);
    questions = questions.concat(quiz.questionBoxNo);
    questions = questions.concat(quiz.questionBox1);
    questions = questions.concat(quiz.questionBox2);
    questions = questions.concat(quiz.questionBox3);
    questions = questions.concat(quiz.questionBoxN);
    quiz.questions = questions;
    Ks.exercise.quiz = quiz;
    Ks.exercise.quiz.allBox = questions.length;


    var idBtnNewExercise = new Date().getTime() + "NewExercise";
    var idQuestionPanel = new Date().getTime() + "questionPanel";

    var template = $("#templateExerciseReview").html();
    Mustache.parse(template);
    var reviewHtml = Mustache.render(template, {isOwner: Ks.exercise.isOwner, quiz : quiz, idQuestionPanel: idQuestionPanel, idBtnNewExercise : idBtnNewExercise,sectionId: Ks.exercise.idSectionCurrent, quizId: Ks.exercise.idQuizCurrent});
    reviewPanel.html(reviewHtml);

    Ks.exercise.questionPanelCurrent = $("#" + idQuestionPanel);
    var label = "All questions";
    Ks.exercise.genQuestion(label, Ks.exercise.quiz.questions);

    Ks.exercise.handler(null, idBtnNewExercise);
};

Ks.exercise.viewProgress = function () {
    var data = {};
    data.action = "loadProgressForAllUser";
    data.quiz = Ks.exercise.idQuizCurrent;
    $.ajax({
        url: "/moodle/koolsoft/exercise/rest",
        data: data,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (result) {
            var keys = Object.keys(result);
            var users = [];
            for(var i=0; i < keys.length; i++){
                users.push(result[keys[i]]);
            }
            $("#exerciseProgressDialog").modal();
            var template = $("#templateExerciseReviewProgess").html();
            Mustache.parse(template);
            var progressHtml = Mustache.render(template, {users: users});
            $("#exerciseProgressDialog").find("#content").html(progressHtml);
        }
    });
};

Ks.exercise.genQuestion = function (label, questions) {
    for(var i=0; i < questions.length; i++){
        questions[i].index = i + 1;
    }
    $("#labelBoxQuestion").html(label);
    $("#pagination-question").twbsPagination('destroy');
    if(questions.length > 0){
    	var totalPage = questions.length / 10 + 1;
        Ks.exercise.pagination = $('#pagination-question').twbsPagination({
            totalPages: totalPage,
            visiblePages: 10,
            first: "",
            last: "",
            prev: "",
            next: "",
            onPageClick: function (event, page) {
            	var questionInPages = questions.slice(10 * (page - 1), 10 * page);
            	var templateQuestion = $("#templateExerciseReviewQuestion").html();
        	    Mustache.parse(templateQuestion);
        	    var questionHtml = Mustache.render(templateQuestion, {questions : questionInPages});
        	    Ks.exercise.questionPanelCurrent.html(questionHtml);
            }
        });
    }else {
         Ks.exercise.questionPanelCurrent.html("");
    }
};

function addHandle(){
    $(".btnBoxActive").click(function(){
        $(".btnBoxActive").css("background-color", "white");
        color_profile = $(this).attr("color_profile");
        $(this).css("background-color", color_profile);
    });
}

$(function () {
	Ks.exercise.isOwner = $("#isOwnerCourse").val();
    $(".showExerciseBtn").click(function () {
        Ks.exercise.idQuizCurrent = $(this).attr("id-quiz-instance");
        Ks.exercise.idSectionCurrent = $(this).attr("id-section");
        Ks.exercise.exercisePanelCurrent = $($(this).attr("href"));
        var data = {};
        data.action = "loadOverview";
        data.quiz = Ks.exercise.idQuizCurrent;
        $.ajax({
            url: "/moodle/koolsoft/exercise/rest",
            data: data,
            success: function (result) {
                var quiz = JSON.parse(result);
                Ks.exercise.genReviewView(quiz, Ks.exercise.exercisePanelCurrent);
            }
        });

    });
    Ks.exercise.init();
});

