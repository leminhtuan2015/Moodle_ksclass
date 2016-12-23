/**
 * Created by dddd on 12/22/16.
 */
var Ks = Ks || {};
Ks.quiz = Ks.quiz || {};
Ks.quiz.numberQuestionInBank = 0;
Ks.quiz.numberQuestion = 0;
Ks.quiz.questions = [];
Ks.quiz.init = function () {
};

Ks.quiz.renderQuestion = function () {
    var htmlTr = "";
    var idQuestions = [];
    for(var i =0; i < Ks.quiz.questions.length; i++){
        htmlTr += "<tr>"
            + "<td><input type='checkbox' value='' id='idCheckBoxQuestion"+ i + "' idQuestion='"+ Ks.quiz.questions[i].id + "' nameQuestion='"+ Ks.quiz.questions[i].name + "'></td>"
            + "<td>" + Ks.quiz.questions[i].name + "</td>"
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
        var idQuestions = [];
        for(var i=0; i < Ks.quiz.numberQuestionInBank; i++){
            if($("#idCheckBox" + i).prop("checked")){
                var questionId = $("#idCheckBox" + i).attr("idquestion");
                var questionName = $("#idCheckBox" + i).attr("namequestion");
                var questionObject = {};
                questionObject.id = questionId;
                questionObject.name = questionName;
                Ks.quiz.questions.push(questionObject);
            }
        }
        Ks.quiz.renderQuestion();
        $("#questionBankDialog").modal('hide');
    });

    $("#id_selectacategory").change(function(){
        var cat = $("#id_selectacategory").val();
        var category = cat.split(',')[0];
        $.ajax({url: "/moodle/koolsoft/questionbank/rest/questionbank_rest.php?categoryid=" + category, success: function(questions){
            var htmlTr = "";
            var keys = Object.keys(questions);
            for(var i = 0; i < keys.length; i++){
                htmlTr += "<tr>"
                    + "<td><input type='checkbox' value='' id='idCheckBox"+ i + "' idQuestion='"+ questions[keys[i]].id + "' nameQuestion='"+ questions[keys[i]].name + "'></td>"
                    + "<td>" + questions[keys[i]].name + "</td>"
                    +"</tr>";
            }
            $("#bodyTableQuestionBank").html(htmlTr);
            Ks.quiz.numberQuestionInBank = keys.length;
        }});
    });
};
$(function () {
    Ks.quiz.init();
    Ks.quiz.handler();
});