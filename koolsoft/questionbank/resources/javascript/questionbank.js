var Ks = Ks || {};
Ks.questionBank = Ks.questionBank || {};
Ks.questionBank.numberQuestionInBank = 0;
Ks.questionBank.currentCategory = 0;
Ks.questionBank.init = function () {
    Ks.questionBank.getQuestions();
};

Ks.questionBank.getQuestions = function () {
    var cat = $("#id_selectacategory").val();
    var category = cat.split(',')[0];
    Ks.questionBank.currentCategory = category;
    $.ajax({url: "/moodle/koolsoft/questionbank/rest/questionbank_rest.php?categoryid=" + category, success: function(questions){
        Ks.questionBank.renderQuestion(questions);
    }});
    var urlEdit = "/moodle/koolsoft/question/?action=edit&category=" + category + "&returnUrl=" + encodeURIComponent(document.URL);
    $("#urlEdit").val(urlEdit);
};
Ks.questionBank.renderQuestion = function (questions) {
    var htmlTr = "";
    var keys = Object.keys(questions);
    for(var i = 0; i < keys.length; i++){
        htmlTr += "<tr>"
            + "<td><input type='checkbox' value='' id='idCheckBox"+ i + "' idQuestion='"+ questions[keys[i]].id + "' nameQuestion='"+ questions[keys[i]].name + "'></td>"
            + "<td>" + questions[keys[i]].name + "</td>"
            + "<td>" + dateFomat(new Date(questions[keys[i]].timecreated * 1000)) + "</td>"
            + "<td>" + dateFomat(new Date(questions[keys[i]].timemodified * 1000)) + "</td>"
            +"</tr>";
    }
    $("#bodyTableQuestionBank").html(htmlTr);
    Ks.questionBank.numberQuestionInBank = keys.length;
};

Ks.questionBank.handler = function () {
    $("#id_selectacategory").change(function(){
        Ks.questionBank.getQuestions();
    });

    $("#editBtn").click(function(){
        window.location.href=encodeURI($("#urlEdit").val());
    });

    $("#showViewDeleteQuestionBtn").click(function(){
        var deleteQuestions = [];
        var deleteQuestionNames = [];
        for(var i=0; i < Ks.questionBank.numberQuestionInBank; i++){
            if($("#idCheckBox" + i).prop("checked")){
                deleteQuestions.push($("#idCheckBox" + i).attr("idquestion"));
                deleteQuestionNames.push($("#idCheckBox" + i).attr("namequestion"));
            }
        }
        if(deleteQuestions && deleteQuestions.length > 0){
            $("#nameQuestions").text(deleteQuestionNames.toString());
            $("#deleteQuestionDialog").modal();
            $("#idQuestions").val(deleteQuestions.toString());
        }else {
            $("#alertDialog").modal();
            $("#alertContent").html("Your must choice question to delete!");
        }
    });

    $("#id_selectacategory").change(function(){
        Ks.questionBank.getQuestions();
    });

    $("#idCheckBoxAll").change(function(){
        for(var i=0; i < Ks.questionBank.numberQuestionInBank; i++){
            $("#idCheckBox" + i).prop('checked', $("#idCheckBoxAll").prop("checked"));
        }
    });

    $("#deleteQuestionBtn").click(function(){
        var idQuestions = $("#idQuestions").val();
        $.ajax({url: "/moodle/koolsoft/questionbank/rest/questionbank_rest.php?idDeletes=" + idQuestions, success: function(result){
            if(result == true){
                Ks.questionBank.getQuestions();
            }
        }});
        $("#deleteQuestionDialog").modal('hide');
    });
};
$(function () {
    Ks.questionBank.init();
    Ks.questionBank.handler();
});

function dateFomat(dateObject) {
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth() + 1;
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    if (month < 10) {
        month = "0" + month;
    }
    var date = day + "/" + month + "/" + year;

    return date;
};

