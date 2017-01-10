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
        var data = {};
        data.action = "loadAllResultQuizForUser";
        data.idCourse = idCourse;
        data.idUser = idUser;
        $("#quizResultForUserHeader").html("Progess for user :" + nameUser);
        $("#quizResultForUserDialog").modal();
        $.ajax({url: "/moodle/koolsoft/quiz/rest/quiz_rest.php",
            data: data,
            success: function(quizResults){
                var html = "";
                var keys = Object.keys(quizResults);
                for(var i = 0; i < keys.length; i++){
                    var quizResult = quizResults[keys[i]];
                    html += "<tr>";
                    html += "<td> " + quizResult.name + " </td>";
                    html += "<td> " + quizResult.state + " </td>";
                    if(quizResult.state == "finished"){
                        html += "<td> " + quizResult.grade + "/" + quizResult.sumgrades + " </td>";
                    }else {
                        html += "<td>  </td>";
                    }
                    html += "<td> " + quizResult.timefinish + " </td>";
                    html += "</tr>";
                }
               $("#quizResultForUserContent").html(html);
            },
            error: function () {
                console.log("get question error !!!!!");
            }
        });
    });


    Ks.quizResultUser.init();

});
