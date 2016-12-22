var Ks = Ks || {};
Ks.questionBank = Ks.questionBank || {};
Ks.questionBank.init = function () {
};

Ks.questionBank.handler = function () {
    $("#id_selectacategory").change(function(){
        window.location.href=encodeURI("?action=show" + "&courseid=" + $("#courseid").val() + "&cat=" + $("#id_selectacategory").val());
    });

    $("#editBtn").click(function(){
        window.location.href=encodeURI($("#urlEdit").val());
    });

    $("#deleteBtn").click(function(){
        var numberQuestion = $("#numberQuestion").val();
        var deleteQuestions = [];
        var deleteQuestionNames = [];
        for(var i=0; i < numberQuestion; i++){
            if($("#idCheckBox" + i).prop("checked")){
                deleteQuestions.push($("#idCheckBox" + i).attr("idquestion"));
                deleteQuestionNames.push($("#idCheckBox" + i).attr("namequestion"));
            }
        }
        if(deleteQuestions && deleteQuestions.length > 0){
            $("#nameQuestions").text(deleteQuestionNames);
            $("#deleteQuestionDialog").modal();
            $("#idQuestions").val(deleteQuestions.toString());
        }
    });
};
$(function () {
    Ks.questionBank.init();
    Ks.questionBank.handler();
});