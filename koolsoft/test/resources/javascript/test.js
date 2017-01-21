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
Ks.test.Timeinterval = null;
Ks.test.forceFinish = false;
Ks.test.isOwner = false;

Ks.test.init = function () {
	Ks.test.numberQuestion = 0;
	Ks.test.idAttemptCurrent = null;
	Ks.test.idTestCurrent = null;
	Ks.test.idTestInstanceCurrent = null;
	Ks.test.idSectionCurrent = null;
	Ks.test.testPanelCurrent = null;
	Ks.test.Timeinterval = null;
	Ks.test.forceFinish = false;
    Ks.test.handler();
};

Ks.test.handler = function () {
    $(".answerQuestionRight").click(function () {
        var value = $(this).attr("answer-value");
        var nameAnswerField = $(this).attr("name-answer-field");
        $("." + nameAnswerField)[value].checked = true;
        var classGroup = $(this).attr("class-group");
        
        $("." + classGroup).css("background-color", "white");
        $("." + classGroup).css("color", "gray");

        $(this).css("background-color", "gray");
        $(this).css("color", "white");
    });

    $("#btnSubmitFormQuestion").click(function () {
    	Ks.test.submitForm();
    });
    
    $(".tagQuestion").click(function () {
    	var indexQuestion = $(this).attr("question-index");
    	var tagType = $(this).attr("type-tag");
    	if(tagType == 0){
    		$("#" + indexQuestion).css("background-color", "rgb(57, 247, 134)");
    	}else if(tagType == 1){
    		$("#" + indexQuestion).css("background-color", "rgb(66, 238, 234)");
    	}else if(tagType == 2){
    		$("#" + indexQuestion).css("background-color", "rgb(236, 152, 68)");
    	}
    });

    $(".answerQuestionLeft").click(function () {
        var value = $(this).val();
        var nameAnswerField = $(this).attr("name-answer-field");
        var length = $("label[name="+ nameAnswerField + "]").length;
        for(var i = 0 ; i < length; i++){
            if(value == i){
            	$($("label[name="+ nameAnswerField + "]")[i]).css("background-color", "gray");
            	$($("label[name="+ nameAnswerField + "]")[i]).css("color", "white");
            }else {
            	$($("label[name="+ nameAnswerField + "]")[i]).css("background-color", "white");
            	$($("label[name="+ nameAnswerField + "]")[i]).css("color", "gray");
            }
        }
    });
};

Ks.test.submitForm = function () {
	var numberQuestionCheck = 0;
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
                    numberQuestionCheck ++;
                }
            }

        }
    }
    
    if((Ks.test.numberQuestion - numberQuestionCheck) > 0 && !Ks.test.forceFinish){
    	$("#submitTestDialog").find(".contentTestSubmit").html("You have not completed " + (Ks.test.numberQuestion - numberQuestionCheck) + " question.");
    	$("#submitTestDialog").modal();
    }else {
    	data.action = "play";
    	$.post(
                '/moodle/koolsoft/test/rest/', 
                data,  
                function(result){ 
                	var startPlay = JSON.parse(result);
        			Ks.test.idAttemptCurrent = startPlay.id;
        			Ks.test.genReviewView(startPlay, Ks.test.testPanelCurrent);
                }, 
                'text' 
        );

    	Ks.test.clearClock();
    }
    
}

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
	Ks.test.numberQuestion = attempt.questions.length;
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
    var deadline = new Date(Date.parse(new Date()) + attempt.quiz.timelimit * 1000);
    Ks.test.initializeClock('clockdiv', deadline, function overTime(){
    	if($("#testPanel").css("display") != "none"){
    		Ks.test.forceFinish = true;
    		$("#submitTestDialog").modal("hide");
    		$("#overTimeDialog").modal();
    	}
    });
};

Ks.test.genReviewView = function (quiz, questionPanel){
    var idBtnNewTest = new Date().getTime() + "NewTest";
    var template = $("#templateTestReview").html();
    Mustache.parse(template);
    var reviewHtml = Mustache.render(template, {isOwner: Ks.test.isOwner, quiz : quiz, idBtnNewTest : idBtnNewTest, sectionId: Ks.test.idSectionCurrent, quizId: Ks.test.idTestInstanceCurrent});

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

Ks.test.getTimeRemaining = function (endtime) {
  var t = Date.parse(endtime) - Date.parse(new Date());
  var seconds = Math.floor((t / 1000) % 60);
  var minutes = Math.floor((t / 1000 / 60) % 60);
  return {
    'total': t,
    'minutes': minutes,
    'seconds': seconds
  };
}

Ks.test.initializeClock = function (id, endtime, callback) {
  var clock = document.getElementById(id);
  var minutesSpan = clock.querySelector('.minutes');
  var secondsSpan = clock.querySelector('.seconds');

  function updateClock() {
    var t = Ks.test.getTimeRemaining(endtime);

    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

    if (t.total <= 0) {
      clearInterval(Ks.test.Timeinterval);
      return callback();
    }
  }

  updateClock();
  Ks.test.Timeinterval = setInterval(updateClock, 1000);
}

Ks.test.clearClock = function (){
	clearInterval(Ks.test.Timeinterval);
}

Ks.test.viewProgress = function () {
    var data = {};
    data.action = "loadProgressForAllUser";
    data.quiz = Ks.test.idTestInstanceCurrent;
    $.ajax({
        url: "/moodle/koolsoft/test/rest",
        data: data,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (result) {
            var keys = Object.keys(result);
            var users = [];
            for(var i=0; i < keys.length; i++){
                users.push(result[keys[i]]);
            }
            $("#testProgressDialog").modal();
            var template = $("#templateTestReviewProgess").html();
            Mustache.parse(template);
            var progressHtml = Mustache.render(template, {users: users});
            $("#testProgressDialog").find("#content").html(progressHtml);
        }
    });
};

$(function () {
	Ks.test.isOwner = $("#isOwnerCourse").val();
	$("#overTimeDialog").on("hidden.bs.modal", function() {
		Ks.test.submitForm();
    });
	
    $(".showQuizBtn").click(function () {
    	Ks.test.init();
    	Ks.test.clearClock();
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
                var resutTest = JSON.parse(result);
                Ks.test.genReviewView(resutTest, Ks.test.testPanelCurrent);
            }
        });
    });
    
});