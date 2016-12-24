var Ks = Ks || {};
Ks.question = Ks.question || {};
Ks.question.numberQuestion = 0;
Ks.question.init = function ($numberQuestion) {
    Ks.question.numberQuestion = $numberQuestion;
};

Ks.question.addQuestion = function () {
    Ks.question.numberQuestion ++;
    stt = Ks.question.numberQuestion - 1;
    var htmlQuestion = "";
    htmlQuestion += "<div id='question"+ stt +"' class='form-group'>";
    htmlQuestion += "<div style='width: 50%' class='questionDiv'>";
    htmlQuestion += "<label class='control-label questionLable' for='questionText"+ stt +"'>Question :</label>";
    htmlQuestion += "<input class='form-control questionText'  name='questionText"+ stt +"' placeholder='Question' required value=''></input>";
    htmlQuestion += "<input style='display: none' name='id"+ stt +"' value=''></input>";
    htmlQuestion += "</div>";
    htmlQuestion += "<div style='width: 50%' class='answerDiv'>";
    htmlQuestion += "<label class='control-label answerLable' for='answerText"+ stt +"'>Answer :</label>";
    htmlQuestion += "<input class='form-control answerText' name='answerText"+ stt +"' placeholder='Answer' value='' required></input>";
    htmlQuestion += "</div>";
    htmlQuestion += "<div style='width: 50%' id='divWrongAnswer"+ stt +"'>";
    for(var i = 0 ; i <  3; i ++){
        htmlQuestion += "<input class='form-control' name='wrongAnswer"+ stt +"_"+ i +"' placeholder='Wrong Answer' value=''required></input>";
    }
    htmlQuestion += "</div></div>";
    $("#formQuestion").append(htmlQuestion);
    $("#numberQuestion").val(Ks.question.numberQuestion);
};

$(function () {
    Ks.question.init($("#numberQuestion").val());
    $("#addQuestion").click(function(){
        Ks.question.addQuestion();
    });
});