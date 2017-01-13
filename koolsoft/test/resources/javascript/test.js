/**
 * Created by dddd on 1/6/17.
 */
/**
 * Created by dddd on 12/22/16.
 */
var Ks = Ks || {};
Ks.test = Ks.test || {};
Ks.test.numberQuestion = 0;
Ks.test.idAttemptCurrent = null;
Ks.test.idTestCurrent = null;
Ks.test.idTestInstanceCurrent = null;
Ks.test.idSectionCurrent = null;
Ks.test.testPanelCurrent = null;

Ks.test.init = function () {
    Ks.test.handler();
};

Ks.test.handler = function () {
    $(".answerQuestionRight").click(function () {
        var value = $(this).attr("answer-value");
        var nameAnswerField = $(this).attr("name-answer-field");
        $("." + nameAnswerField)[value].checked = true;
    });

    $("#btnSubmitFormQuestion").click(function () {
        var value = $(this).attr("answer-value");
        var nameAnswerField = $(this).attr("name-answer-field");
        var data = {};
        var inputDatas = $("input[is-submit=true]");
        var length = inputDatas.length;
        for(var i = 0; i < length; i++){
            var input = $(inputDatas[i]);
            if(input.attr("name")){
                if(input.attr("type") != "radio"){
                    data[input.attr("name")] = input.val();
                }else {
                    if(input.prop("checked") == true){
                        data[input.attr("name")] = input.val();
                    }
                }

            }
        }

        data.action = "play";
        $.ajax({
            url: "/moodle/koolsoft/test/rest",
            data: data,
            success: function (result) {
                var startPlay = JSON.parse(result);
                Ks.test.idAttemptCurrent = startPlay.id;
                Ks.test.genReviewView(startPlay, Ks.test.testPanelCurrent);
            },
            error : function () {
                console.log("submit for play error!");
            }

        });
    });

    $(".answerQuestionLeft").click(function () {
        var value = $(this).val();
        var nameAnswerField = $(this).attr("name-answer-field");
        var length = $("label[name="+ nameAnswerField + "]").length;
        for(var i = 0 ; i < length; i++){
            if(value == i){
                $($("label[name="+ nameAnswerField + "]")[i]).addClass("active");
            }else {
                $($("label[name="+ nameAnswerField + "]")[i]).removeClass("active");
            }
        }
    });
};

Ks.test.showQuestion = function (index) {
    for(var i = 1; i <= Ks.test.numberQuestion; i++){
        if(i == index){
            $("#questionDiv" + i).css("display", "block");
        }else {
            $("#questionDiv" + i).css("display", "none");
        }
    }
};

Ks.test.genPlayView = function (attempt, questionPanel){
    var template = $("#templateTest").html();
    var labelAnswer = ["A", "B", "C", "D", "E", "F"];
    var questions = attempt.questions;
    var sequenceChecks = attempt.sequenceChecks;
    for (var i = 0; i < questions.length; i++){
        questions[i].index = i + 1;
        questions[i].uniqueid = attempt.uniqueid;
        questions[i].sequencecheckName = "q" + attempt.uniqueid + ":"+ (i + 1) + "_:sequencecheck";
        questions[i].sequencecheckValue = sequenceChecks[i];

        for(var j =0; j < questions[i].answers.length; j++){
            questions[i].answers[j].fieldValue = j;
            questions[i].answers[j].fieldName = "q"+ attempt.uniqueid +":" + (i + 1) + "_answer";
            questions[i].answers[j].fieldClass = "q"+ attempt.uniqueid + (i + 1) + "_answer";
            questions[i].answers[j].label = labelAnswer[j];
        }
    }

    Mustache.parse(template);
    var questionHtml = Mustache.render(template, {attempt : attempt, sectionId: Ks.test.idSectionCurrent, quizId: Ks.test.idTestInstanceCurrent});

    questionPanel.html(questionHtml);
    Ks.test.handler();
};

Ks.test.genReviewView = function (quiz, questionPanel){
    var idBtnNewTest = new Date().getTime() + "NewTest";
    var template = $("#templateTestReview").html();
    Mustache.parse(template);
    var reviewHtml = Mustache.render(template, {quiz : quiz, idBtnNewTest : idBtnNewTest, sectionId: Ks.test.idSectionCurrent, quizId: Ks.test.idTestInstanceCurrent});

    questionPanel.html(reviewHtml);

    $("#" + idBtnNewTest).click(function () {
        var data = {};
        data.action = "start";
        data.cmid = Ks.test.idTestCurrent;
        data.forcenew = true;
        $.ajax({
            url: "/moodle/koolsoft/test/rest",
            data: data,
            success: function (result) {
                var startPlay = JSON.parse(result);
                Ks.test.idAttemptCurrent = startPlay.id;
                Ks.test.genPlayView(startPlay, Ks.test.testPanelCurrent);
            }
        });
    });

};

$(function () {
    $(".showQuizBtn").click(function () {
        Ks.test.idTestCurrent = $(this).attr("id-quiz");
        Ks.test.idTestInstanceCurrent = $(this).attr("id-quiz-instance");
        Ks.test.idSectionCurrent = $(this).attr("id-section");
        Ks.test.testPanelCurrent = $($(this).attr("href"));
        var data = {};
        data.action = "loadResult";
        data.quiz = Ks.test.idTestInstanceCurrent;
        $.ajax({
            url: "/moodle/koolsoft/test/rest",
            data: data,
            success: function (result) {
                console.log(result);
                var resutTest = JSON.parse(result);
                Ks.test.genReviewView(resutTest, Ks.test.testPanelCurrent);
            }
        });
    });
    Ks.test.init();
});