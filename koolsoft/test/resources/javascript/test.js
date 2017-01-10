/**
 * Created by dddd on 1/6/17.
 */
/**
 * Created by dddd on 12/22/16.
 */
var Ks = Ks || {};
Ks.test = Ks.test || {};
Ks.test.numberQuestion = 0;
Ks.test.idTestCurrent = null;
Ks.test.testPanelCurrent = null;

Ks.test.init = function () {
    Ks.test.handler();
};

Ks.test.handler = function () {
    Ks.test.numberQuestion = $("#numberQuestion").val();
    for(var i = 1; i <= Ks.test.numberQuestion; i++){
        $("#questionBtn" + i).click(function () {
            Ks.test.showQuestion($(this).attr("indexQuestion"));
        });
    }
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
    var questionHtml = "";
    var questionFooterHtml = "";
    questionHtml += "<div class='container'>";
    questionHtml += "<h4>Start quiz : " + attempt.quiz.name + "</h4>";
    questionHtml += "<form action='/moodle/koolsoft/test/?action=process' method='post' id='formQuestion' role='form'>";
    var questions = attempt.questions;
    var sequenceChecks = attempt.sequenceChecks;
    for (var i = 0; i < questions.length; i++){
        var question = questions[i];
        var prefix = "";
        if(i != 0){
            prefix = " style='display: none;' ";
        }
        var answers = question.options.answers;
        var keys= Object.keys(answers);
        questionHtml += "<div " + prefix + " id='questionDiv" + (i + 1) + "'> <label> Question " + (i + 1) + " : " + question.name + "</label> <br>";
        questionHtml += "<input type='hidden' name='q" + attempt.uniqueid + ":"+ (i + 1) + "_:sequencecheck' value='" + sequenceChecks[i] + "'>";

        for(var j =0; j < keys.length; j++){
            var answer = answers[keys[j]];
            questionHtml += "<input type='radio' value='"+ j +"' name='q"+ attempt.uniqueid +":" + (i + 1) + "_answer'><label>" + answer.answer + "</label> <br>";
        }

        questionHtml += "</div>";

        questionFooterHtml += "<button class='btn btn-primary' indexQuestion='" + (i + 1)+ "' id='questionBtn" + (i + 1) + "'>" + (i + 1) + "</button>";
    }

    questionHtml += "<input type='hidden' name='action' value='process' >";
    questionHtml += "<input type='hidden' name='finishattempt' value='true' >";
    questionHtml += "<input type='hidden' name='attempt' value=" + attempt.id + " >";
    questionHtml += "<input type='hidden' name='thispage' value='0' >";
    questionHtml += "<input type='hidden' name='nextpage' value='-1' >";
    questionHtml += "<input type='hidden' name='timeup' value='0' id='timeup'>";
    questionHtml += "<input type='hidden' name='scrollpos' value='' id='scrollpos'>";
    questionHtml += "<input type='hidden' name='slots' value="+ attempt.slotString + " >";
    questionHtml += "</form>";

    questionHtml += "<input type='hidden' id='numberQuestion' value='"+ questions.length + "' >";
    questionHtml += "<div class='container'>";
    questionHtml += questionFooterHtml;

    questionHtml += "</div>";
    questionHtml += "<br> <br> <button type='submit' form='formQuestion' class='btn btn-primary'> Finish test </button> </div>";

    questionPanel.html(questionHtml);
    Ks.test.handler();
};

Ks.test.genReviewView = function (reviewData, questionPanel){
    var idBtnNewTest = new Date().getTime() + "NewTest";
    var html = "<div class='container'>";
    html += "<h4>Result quiz : " + reviewData.quizName + "</h4>";
    html += "<div class='sumary'>";
    html += "<label>Started on : "+ reviewData.summarydata["startedon"]["content"] + "</label><br>";
    html += "<label>State : "+ reviewData.summarydata["state"]["content"] + "</label><br>";
    html += "<label>Completed on : "+ reviewData.summarydata["completedon"]["content"] + "</label><br>";
    html += "<label>Time taken : "+ reviewData.summarydata["timetaken"]["content"] + "</label><br>";
    html += "<label>Grade : "+ reviewData.summarydata["grade"]["content"] + "</label><br>";
    html += "<button id='" + idBtnNewTest + "'>New test</button>";
    html += "</div>";
    html += "</div>";
    questionPanel.html(html);

    $("#" + idBtnNewTest).click(function () {
        var data = {};
        data.action = "preForPlay";
        data.cmid = Ks.test.idTestCurrent;
        data.newTest = true;
        $.ajax({
            url: "/moodle/koolsoft/test/rest/test.php",
            data: data,
            success: function (result) {
                //gen view play
                var preResult = JSON.parse(result);
                if(preResult.status == "start"){
                    $.ajax({
                        url: "/moodle/koolsoft/test/rest/test.php",
                        data: {action : "loadForPlay", id : preResult.id},
                        success: function (result) {
                            Ks.test.genPlayView(JSON.parse(result), Ks.test.testPanelCurrent);
                        },
                        error : function () {
                            console.log("load for play error!");
                        }

                    });
                }
            }
        });
    });

};

$(function () {
    $(".showQuizBtn").click(function () {
        Ks.test.idTestCurrent = $(this).attr("id-quiz");
        Ks.test.testPanelCurrent = $($(this).attr("href"));
        var data = {};
        data.action = "preForPlay";
        data.cmid = Ks.test.idTestCurrent;
        $.ajax({
            url: "/moodle/koolsoft/test/rest/test.php",
            data: data,
            success: function (result) {
                //gen view play
                var preResult = JSON.parse(result);
                if(preResult.status == "start"){
                    $.ajax({
                        url: "/moodle/koolsoft/test/rest/test.php",
                        data: {action : "loadForPlay", id : preResult.id},
                        success: function (result) {
                            Ks.test.genPlayView(JSON.parse(result), Ks.test.testPanelCurrent);
                        },
                        error : function () {
                            console.log("load for play error!");
                        }

                        });
                }else {
                    $.ajax({
                        url: "/moodle/koolsoft/test/rest/test.php",
                        data: {action : "loadTestResult", id : preResult.id},
                        success: function (result) {
                            Ks.test.genReviewView(JSON.parse(result), Ks.test.testPanelCurrent);
                        },
                        error : function () {
                            console.log("load for play error!");
                        }

                    });
                }
            }
        });
    });
    Ks.test.init();
});