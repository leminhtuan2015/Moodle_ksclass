/**
 * Created by dddd on 12/22/16.
 */
var Ks = Ks || {};
Ks.quiz = Ks.quiz || {};
Ks.quiz.numberQuestionInBank = 0;
Ks.quiz.questionInBank = null;
Ks.quiz.numberQuestion = 0;
Ks.quiz.questionCurrentIndex = 0;
Ks.quiz.questions = [];
Ks.quiz.numberWrongAnswer = 3;
Ks.quiz.wrongAnswerInputId = "wrongAnserTxt";
Ks.quiz.typeTest = 2;
Ks.quiz.typeExercise = 1;
Ks.quiz.tagSelects = [];
Ks.quiz.init = function () {
    Ks.quiz.loadLecture();

    var dateTimeFormat = "YYYY/MM/DD h:m A";
    $("#datetimepickerStart").datetimepicker({
        format : dateTimeFormat
    });
    $("#datetimepickerEnd").datetimepicker({
        format : dateTimeFormat
    });

    $.ajax({url: "/moodle/koolsoft/question_tag/rest/question_tag.php?action=listAll",
        success: function(results){
            var tags = JSON.parse(results);
            var keys = Object.keys(tags);
            var tagSelects = [];
            for(var i = 0 ;  i < keys.length; i ++ ){
                var tag = {};
                tag.id = tags[keys[i]].id;
                tag.text = tags[keys[i]].name;
                Ks.quiz.tagSelects.push(tag);
            }

            $("#selectTagSearch").select2({
                data: Ks.quiz.tagSelects,
                tags: true,
                tokenSeparators: [',', ' ']
            });

            $("#selectTagCreateQuestion").select2({
                data: Ks.quiz.tagSelects,
                tags: true,
                tokenSeparators: [',', ' ']
            });
        },
        error: function () {
            console.log("get tag error !!!!!");
        }
    });

    $("#createQuizDialog").on("shown.bs.modal", function() {
        Ks.quiz.clearDialog();
        var idQuiz = $("#idQuiz").val();
        if(idQuiz){
            Ks.quiz.loadQuiz(idQuiz);
        }
    });

};

Ks.quiz.clearDialog = function () {
    $("#listQuestion").html("");
    Ks.quiz.numberQuestionInBank = 0;
    Ks.quiz.numberQuestion = 0;
    Ks.quiz.questions = [];
    Ks.quiz.questionDeletes = [];
    Ks.quiz.clearQuestionDetailView();
    $("#nameQuiz").val("");
    $("#descQuiz").val("");
    $("#startTime").val("");
    $("#endTime").val("");

    $("#chapterSelect option")[0].selected = true;
    $("#lectureSelect").html("");

    if($("#idQuiz").val()){
        $("#questionMainPanel").css("display", "block");
    }else {
        $("#questionMainPanel").css("display", "none");
    }

    Ks.quiz.showTimePanel(Ks.quiz.typeExercise, 0);

    Ks.quiz.loadLecture();

};

Ks.quiz.handler = function () {
    $("#chapterSelect").change(function(){
        Ks.quiz.loadLecture();
    });

    $("#startTime").on('dp.change',function(event){
        Ks.quiz.validateDate();
    });
    $("#endTimeText").on('dp.change',function(event){
        Ks.quiz.validateDate();
    });

    $("#typeQuizSelect").change(function () {
        Ks.quiz.showTimePanel($(this).val(), 0);
    });

    $("#removeOneQuestionBtn").click(function(){
        var index = $("#questionIndex").val();
        Ks.quiz.deleteOneQuestion(index);

    });

    $("#btnAddQuestionNew").click(function() {
        var question = {};
        question.question = "";
        question.answer = "";
        var wrongAnswer = [];
        wrongAnswer.push("");
        wrongAnswer.push("");
        wrongAnswer.push("");

        question.wrongAnswer = wrongAnswer;

        Ks.quiz.questions.push(question);
        Ks.quiz.numberQuestion = Ks.quiz.questions.length;
        Ks.quiz.genQuestionTitle();
    });

    $("#btnAddQuestion").click(function(){
    	$('#paginationQuestionBank').twbsPagination("destroy");
    	Ks.quiz.questionInBank = null;
    	Ks.quiz.numberQuestion = 0;
    	$("#bodyTableQuestionBank").html("");
    	$("#idCheckBoxQuestionBankAll").prop("checked", false);
        $("#questionBankDialog").modal();
    });

    $("#btnAddQuestionInBank").click(function(){
        var questionExittingName = [];
        var questionIds = [];
        for(var i=0; i < Ks.quiz.numberQuestionInBank; i++){
            if($("#idCheckBoxQuestionBank" + i).prop("checked")){
                var questionId = $("#idCheckBoxQuestionBank" + i).attr("idquestion");
                var questionName = $("#idCheckBoxQuestionBank" + i).attr("namequestion");

                var check = false;
                for(var j =0; j < Ks.quiz.questions.length; j++){
                    if(Ks.quiz.questions[j].id == questionId){
                        check = true;
                    }
                }
                if(check){
                    questionExittingName.push(questionName);
                }else {
                    questionIds.push(questionId);
                }
            }
        }

        if(questionExittingName && questionExittingName.length > 0){
            $("#alertDialog").modal();
            $("#alertContent").html("Some question exitting in quiz: " + questionExittingName.toString());
        }

        if(questionIds.length > 0){
            var data = {};
            data.action = "listByIds";
            data.id = JSON.stringify(questionIds);
            $.ajax({url: "/moodle/koolsoft/question/rest",
                data: data,
                success: function(results){
                    var questions = JSON.parse(results);
                    for(var i =0; i < questions.length; i++){
                        Ks.quiz.questions.push(Ks.quiz.convertQuestion(questions[i]));
                    }
                    Ks.quiz.genQuestionTitle();
                    $("#questionBankDialog").modal('hide');

                },
                error: function () {
                    console.log("load question error !");
                }
            });
        }

    });

    $("#saveOneQuestionBtn").click(function(){
    	Ks.quiz.saveQuestionInLocal();
        alert("Save question success!");
    });

    $("#saveQuiz").click(function (e) {
        e.preventDefault();

        Ks.quiz.saveQuestionInLocal();
        var questionIds = [];
        var questionNews = [];
        for(var i = 0; i < Ks.quiz.questions.length; i++){
            var question = Ks.quiz.questions[i];
            question.index = i;
            if(!question.id || question.id == "undefined"){
                questionNews.push(question);
            }else {
                questionIds.push(question.id);
            }
        }
        if(questionNews.length > 0){
            var data = { };
            data.questions = JSON.stringify(questionNews);
            data.action = "create";
            data.data_type = "json";
            $.ajax({
            	url: "/moodle/koolsoft/question/rest" , 
            	data: data,
                success: function(result){
                    var questions = JSON.parse(result);
                    var keys = Object.keys(questions);
                    for(var i = 0; i < keys.length ; i++){
                        var question = questions[keys[i]];
                        if(question.resultText != "Success"){
                            Ks.quiz.genDetailQuestion(question, question.index);
                            $("#createQuestionErrorText").html(question.resultText);
                            $("#createQuestionErrorText").css("display", "block");
                            return;
                        }
                    }

                    for(var i = 0; i < keys.length ; i++) {
                        var question = questions[keys[i]];
                        questionIds.push(question.id);
                    }

                    Ks.quiz.submitForm(questionIds);

                }
            });
        }else {
            Ks.quiz.submitForm(questionIds);
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

    $("#formQuiz").validate({
        // Specify validation rules
        rules: {
            nameQuiz: "required",
            descQuiz: "required",
            section: "required"
        },
        messages: {
            nameQuiz: "Please enter your quiz name",
            descQuiz: "Please enter your quiz description",
            section: "Please enter your lecture"
        },

        submitHandler: function(form) {
            if($("#typeQuizSelect").val() == 1){
                form.submit();
            }else {
                $("#error_end_time").text("");
                $("#error_start_time").text("");
                $("#error_limit_time").text("");


                if($("#timeLimit").val() < 1){
                    $("#error_limit_time").text("Please enter limit time more than 1");
                    return;
                }

                var startDate = $("#startTime").val();
                var endDate = $("#endTime").val();

                if(!startDate){
                    startDate = 0;
                }

                if(!endDate){
                    endDate = 0;
                }

                var startDate1 = new Date(startDate);
                var endDate1 = new Date(endDate);
                var valid = startDate1 <= endDate1;

                if(!startDate1 || startDate1 < new Date()){
                    $("#error_start_time").text("Please enter start time valid");
                    return;
                }

                if(!endDate1 || endDate1 < new Date()){
                    $("#error_end_time").text("Please enter end time valid");
                    return;
                }

                if(!valid){
                    $("#error_end_time").text("Please makesure end time is more than start time");
                    return;
                }

                form.submit();
            }

        }
    });
};

Ks.quiz.saveQuestionInLocal = function () {
	var question = {};
    var indexQuestion = $("#questionIndex").val();
    question.id = $("#questionId").val();
    if(!question.id || question.id == ""){
    	question.question = $("#questionTxt").val();
    	question.answer = $("#answerTxt").val();
    	question.qtype = "multichoice";
    	var wrongAnswer = [];
    	question.tags = $("#selectTagCreateQuestion").val();
    	for(var i = 1; i <= Ks.quiz.numberWrongAnswer; i ++){
    		wrongAnswer[i-1] = $("#" + Ks.quiz.wrongAnswerInputId + i).val();
    	}
    	
    	question.wrongAnswer = wrongAnswer;
    	
    	Ks.quiz.questions[indexQuestion] = question;
    }
};

Ks.quiz.submitForm = function (questionIds) {
    $("#idQuestions").val(questionIds.toString());
    $("#formQuiz").submit();
};

Ks.quiz.loadQuiz= function (quizId) {
    var data = {};
    data.action = "loadQuiz";
    data.quizId = quizId;
    $.ajax({url: "/moodle/koolsoft/quiz/rest",
        data : data,
        success: function(result){
            var quiz = JSON.parse(result);
            $("#nameQuiz").val(quiz.name);
            $("#descQuiz").val(quiz.intro);

            $("#startTime").val(quiz.timeopen);
            $("#endTime").val(quiz.timeclose);

            //load chapter and lecture
            var data= {};
            data.action = "listSectionEqualParent";
            data.idSection = $("#idSection").val();
            $.ajax({url: "/moodle/koolsoft/course/rest/course.php",
                data: data,
                success: function(results){
                    $("#lectureSelect").html("");
                    var sections = JSON.parse(results);
                    var keys = Object.keys(sections);
                    var htmlSelect = "";
                    for(var i = 0; i < keys.length; i++){
                        htmlSelect += "<option value='" + sections[keys[i]].id + "'> " + sections[keys[i]].name + "</option>";
                    }
                    $("#lectureSelect").html(htmlSelect);

                    $("#lectureSelect").val($("#idSection").val());
                },
                error: function () {
                    $("#lectureSelect").html("");
                    console.log("get lecture error !!!!!");
                }
            });

            Ks.quiz.showTimePanel(quiz.type, quiz.timelimit);

            var questions = quiz.questions;
            Ks.quiz.questions = [];
            for(var i = 0; i < questions.length; i++){
                var question = questions[i];
                Ks.quiz.questions.push(Ks.quiz.convertQuestion(question));
            }

            Ks.quiz.genQuestionTitle();

        },
        error: function () {
            console.log("load quiz error !");
        }
    });
};

Ks.quiz.showTimePanel = function (typeQuiz, timeLimit) {
    if(typeQuiz == Ks.quiz.typeTest){
        $("#typeQuizSelect option")[1].selected = true;
        $("#timeLimitPanel").css("display", "inline-block");
        $("#timeQuizPanel").css("display", "block");
        $("#timeLimit").val(timeLimit);
    }else {
        $("#typeQuizSelect option")[0].selected = true;
        $("#timeLimitPanel").css("display", "none");
        $("#timeQuizPanel").css("display", "none");
        $("#timeLimit").val("");
        $("#startTime").val("");
        $("#endTime").val("");
    }
};

Ks.quiz.genQuestionTitle = function () {
    $("#questionMainPanel").css("display", "block");
    $("#listQuestion").html("");
    var idQuestions = [];
    for(var i=0; i < Ks.quiz.questions.length; i++){
        var html = "";
        var idQuestionBtn = new Date().getTime() + i;
        html += "<li  role='presentation' class='brand-nav' index-question='"+ i +"' id-question='" + Ks.quiz.questions[i].id + "' id='" + idQuestionBtn + "' tyle='height: 30px;'>";
        html += "<a role='tab' style='text-align: center;' data-toggle='tab'>" + (i + 1) + "</a>";
        html += "</li>";
        $("#listQuestion").append(html);
        $("#" + idQuestionBtn).click(function (e){
            Ks.quiz.genDetailQuestion(Ks.quiz.questions[$(this).attr("index-question")], $(this).attr("index-question"));
        });
        if(i == (Ks.quiz.questions.length - 1)){
            $("#" + idQuestionBtn).addClass("active");
        }

        if(!Ks.quiz.questions[i].slotid){
            idQuestions.push(Ks.quiz.questions[i].id);
        }
    }

    Ks.quiz.numberQuestion = Ks.quiz.questions.length;
    $("#idQuestions").val(idQuestions.toString());
    if(Ks.quiz.questions.length > 0){
        Ks.quiz.genDetailQuestion(Ks.quiz.questions[Ks.quiz.questions.length - 1], Ks.quiz.questions.length - 1);
    }else {
        Ks.quiz.clearQuestionDetailView();
    }
};

Ks.quiz.genDetailQuestion = function (question, index) {
    $("#createQuestionErrorText").html("");
    $("#createQuestionErrorText").css("display", "none");
    var template = $("#templateQuestion").html();
    Mustache.parse(template);
    
    var questionDisplay = {};
    questionDisplay.id = question.id;
    questionDisplay.answer = question.answer;
    questionDisplay.question = question.question;
    
    var wrongAnswer = [];
    for(var i = 0; i < question.wrongAnswer.length; i++){ 
    	var answer = {};
    	answer.answer = question.wrongAnswer[i];
    	answer.index = i + 1;
    	wrongAnswer.push(answer);
    }
    questionDisplay.wrongAnswer = wrongAnswer;
    
    var questionHtml = Mustache.render(template, {question : questionDisplay, index: index});
    $("#questionDiv").html("");
    $("#questionDiv").append(questionHtml);
    
    $("#selectTagCreateQuestion").select2({
        data: Ks.quiz.tagSelects,
        tags: true,
        tokenSeparators: [',', ' ']
    });

    $("#selectTagCreateQuestion").val(question.tags).trigger("change");
    $("#selectTagCreateQuestionDiv").css("display", "block");
    $("#removeOneQuestionBtn").css("display", "inline-block");
    if(question.id && question.id != "undefined"){
        $("#saveOneQuestionBtn").css("display", "none");
        $("#selectTagCreateQuestion").select2("enable", false);
    }else {
        $("#saveOneQuestionBtn").css("display", "inline-block");
        $("#selectTagCreateQuestion").select2("enable");
    }

};

Ks.quiz.deleteOneQuestion = function (index) {
    Ks.quiz.questions.splice(index, index + 1);
    Ks.quiz.clearQuestionDetailView();
    Ks.quiz.genQuestionTitle();
};

Ks.quiz.clearQuestionDetailView = function (){
    $("#questionDiv").html("");
    $("#selectTagCreateQuestionDiv").css("display", "none");
    $("#createQuestionErrorText").css("display", "none");
    $("#saveOneQuestionBtn").css("display", "none");
    $("#removeOneQuestionBtn").css("display", "none");
};

Ks.quiz.loadQuestionByTag = function () {
    var tag = $("#selectTagSearch").val();
    var data = {};
    data.tag = JSON.stringify(tag);
    data.action = "listByTag";
    $.ajax({url: "/moodle/koolsoft/question/rest",
        data: data,
        success: function(results){
            var questions = JSON.parse(results);
            Ks.quiz.questionInBank = [];
            var keys = Object.keys(questions);
            var htmlTr = "";
            for(var i = 0; i < keys.length; i++){
                if(questions[keys[i]].id){
                	Ks.quiz.questionInBank.push(questions[keys[i]]);
                }
            }
            
            var totalPage;
            if(Ks.quiz.questionInBank.length % 10 > 0){
            	totalPage = Ks.quiz.questionInBank.length / 10 + 1;
            }else {
            	totalPage = Ks.quiz.questionInBank.length / 10;
            }
            
            $('#paginationQuestionBank').twbsPagination("destroy");
            Ks.exercise.pagination = $('#paginationQuestionBank').twbsPagination({
                totalPages: totalPage,
                visiblePages: 10,
                first: "",
                last: "",
                prev: "",
                next: "",
                onPageClick: function (event, page) {
                	var questionInPages = Ks.quiz.questionInBank.slice(10 * (page - 1), 10 * page);
                	var htmlTr= "";
                	for(var i=0; i < questionInPages.length; i++){
                		 htmlTr += "<tr>"
                             + "<td><input type='checkbox' value='' id='idCheckBoxQuestionBank"+ i + "' idQuestion='"+ questionInPages[i].id + "' nameQuestion='"+ questionInPages[i].name + "'></td>"
                             + "<td>" + questionInPages[i].name + "</td>"
                             +"</tr>";
                	}
                	
                	$("#bodyTableQuestionBank").html(htmlTr);
                }
            });

            Ks.quiz.numberQuestionInBank = Ks.quiz.questionInBank.length;
            
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
                htmlSelect += "<option value='" + sections[keys[i]].id + "'> " + sections[keys[i]].name + "</option>";
            }
            $("#lectureSelect").html(htmlSelect);

        },
        error: function () {
            $("#lectureSelect").html("");
            console.log("get lecture error !!!!!");
        }
    });
};

Ks.quiz.convertQuestion = function (question) {
    var questionResult = {};
    questionResult.question = question.questiontext;
    questionResult.id = question.id;
    var answers = question.options.answers;
    var wrongAnswer = [];
    var keys = Object.keys(answers);


    if(keys.length > 0){
        questionResult.answer = answers[keys[0]].answer;
    }

    for(var i = 1; i < keys.length; i++) {
        wrongAnswer.push(answers[keys[i]].answer);
    }
    questionResult.wrongAnswer = wrongAnswer;

    questionResult.tags = question.tags;
    return questionResult;
};

Ks.quiz.validateDate = function(){
    var startDate = $("#startTime").val()
    var endDate = $("#endTime").val()

    if(!startDate){
        startDate = 0
    }

    if(!endDate){
        endDate = 0
    }

    var startDate1 = new Date(startDate);
    var endDate1 = new Date(endDate);
    var valid = startDate1 <= endDate1;

    if(!valid){
        $("#error_end_time").text("Please makesure end time is more than start time");
    } else {
        $("#error_end_time").text("");
    }

    return valid;
};

Ks.quiz.initQuiz = function (idSection, idQuiz) {
    $("#idQuiz").val(idQuiz);
    $("#idSection").val(idSection);
    $("#createQuizDialog").modal();
};

$(function () {

    $(".createQuizBtn").click(function () {
        $("#idQuiz").val("");
        $("#createQuizDialog").modal();
    });
    Ks.quiz.init();
    Ks.quiz.handler();

});