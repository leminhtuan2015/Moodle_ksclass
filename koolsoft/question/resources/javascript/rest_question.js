/**
 * Created by leminhtuan on 1/11/17.
 */

function getByTag(){
    var data = {};
    data.action = "listByTag";
    data.data_type = "html";

    $.ajax({url: "/moodle/koolsoft/question/rest/index.php/",
        data: data,
        success: function(htmlResponse){
           $("#question_list").html(htmlResponse);
        },
        error: function () {
            console.log("get question error !!!!!");
        }
    });
}

getByTag();