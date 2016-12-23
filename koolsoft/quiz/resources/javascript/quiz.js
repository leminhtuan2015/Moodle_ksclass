/**
 * Created by dddd on 12/22/16.
 */
var Ks = Ks || {};
Ks.quiz = Ks.quiz || {};
Ks.quiz.numberQuestionInBank = 0;
Ks.quiz.numberQuestion = 0;
Ks.quiz.questions = [];
Ks.quiz.init = function () {
    Ks.quiz.getQuestionForBanks();
    Ks.quiz.getSlotForQuiz();
};

Ks.quiz.renderQuestion = function () {
    var htmlTr = "";
    var idQuestions = [];
    for(var i =0; i < Ks.quiz.questions.length; i++){
        htmlTr += "<tr>"
            + "<td>" + (i + 1) +"</td>"
            + "<td>" + Ks.quiz.questions[i].name + "</td>"
            + "<td><span class='glyphicon glyphicon-trash'></span> </td>"
            +"</tr>";
        idQuestions.push(Ks.quiz.questions[i].id);
    }
    Ks.quiz.numberQuestion = Ks.quiz.questions.length;
    $("#idQuestions").val(idQuestions.toString());
    $("#bodyTableQuestion").html(htmlTr);
}
Ks.quiz.handler = function () {
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
        Ks.quiz.renderQuestion();
        $("#questionBankDialog").modal('hide');
    });

    $("#id_selectacategory").change(function(){
        Ks.quiz.getQuestionForBanks();
    });

    $("#idCheckBoxQuestionBankAll").change(function(){
        for(var i=0; i < Ks.quiz.numberQuestionInBank; i++){
            $("#idCheckBoxQuestionBank" + i).prop('checked', $("#idCheckBoxQuestionBankAll").prop("checked"));
        }
    });
};

Ks.quiz.getQuestionForBanks = function () {
    var cat = $("#id_selectacategory").val();
    var category = cat.split(',')[0];
    $.ajax({url: "/moodle/koolsoft/questionbank/rest/questionbank_rest.php?categoryid=" + category, success: function(questions){
        var htmlTr = "";
        var keys = Object.keys(questions);
        for(var i = 0; i < keys.length; i++){
            htmlTr += "<tr>"
                + "<td><input type='checkbox' value='' id='idCheckBoxQuestionBank"+ i + "' idQuestion='"+ questions[keys[i]].id + "' nameQuestion='"+ questions[keys[i]].name + "'></td>"
                + "<td>" + questions[keys[i]].name + "</td>"
                +"</tr>";
        }
        $("#bodyTableQuestionBank").html(htmlTr);
        Ks.quiz.numberQuestionInBank = keys.length;
    }});
};

Ks.quiz.getSlotForQuiz= function () {
    var quizId = $("#idQuiz").val();
    console.log(quizId);
    if(quizId){
        $.ajax({url: "/moodle/koolsoft/quiz/rest/quiz_rest.php?quizId=" + quizId, success: function(slots){
            var keys = Object.keys(slots);
            for(var i = 0; i < keys.length; i++){
                var question = {};
                question.id = slots[keys[i]].id;
                question.name = slots[keys[i]].name;
                question.maxmark = slots[keys[i]].maxmark;
                Ks.quiz.questions.push(question);
            }
            Ks.quiz.renderQuestion();
        }});
    }
};
$(function () {
    Ks.quiz.init();
    Ks.quiz.handler();

});