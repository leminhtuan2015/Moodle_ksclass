/**
 * Created by dddd on 1/10/17.
 */

var Ks = Ks || {};
Ks.quizResultUser = Ks.quizResultUser || {};
Ks.quizResultUser.init = function () {

};

$(function () {
    $(".showQuizResultUser").click(function () {
        var idCourse = $(this).attr("id-course");
        var idUser = $(this).attr("id-user");
        var nameUser = $(this).attr("name-user");
        $("#quizResultForUserHeader").html("Progess for user :" + nameUser);
        $("#quizResultForUserDialog").modal();
        $('a[href="#test"]').click();
        var data = {};
        data.idCourse = idCourse;
        data.idUser = idUser;

        data.action = "loadResultTestForUser";
        $.ajax({url: "/moodle/koolsoft/quiz/rest",
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(quizResults){
                var html = "";
                var keys = Object.keys(quizResults);
                for(var i = 0; i < keys.length; i++){
                    var quizResult = quizResults[keys[i]];
                    html += "<tr>";
                    html += "<td> " + quizResult.name + " </td>";
                    if(quizResult.state == "finished"){
                        html += "<td> " + quizResult.grade + "/" + quizResult.sumgrades + " </td>";
                        html += "<td> " + quizResult.timefinish + " </td>";
                    }else {
                        html += "<td>  </td>";
                        html += "<td>  </td>";
                    }
                    html += "</tr>";
                }
               $("#quizResultTestForUser").html(html);
            },
            error: function () {
                console.log("get result test error !!!!!");
            }
        });

        data.action = "loadResultExerciseForUser";
        $.ajax({url: "/moodle/koolsoft/quiz/rest",
            data: data,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(quizResults){
                var html = "";
                var keys = Object.keys(quizResults);
                for(var i = 0; i < keys.length; i++){
                    var quizResult = quizResults[keys[i]];
                    html += "<tr>";
                    html += "<td> " + quizResult.name + " </td>";
                    html += "<td> " + quizResult.progress + " </td>";
                    html += "</tr>";
                }
               $("#quizResultExerciseForUser").html(html);
            },
            error: function () {
                console.log("get result exercise error !!!!!");
            }
        });
    });


    Ks.quizResultUser.init();

});
