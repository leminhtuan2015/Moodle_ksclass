/**
 * Created by leminhtuan on 1/14/17.
 */
function getByTag(page){
    // alert("get : " + page)

    var data = {}
    data.action = "listByTag"
    data.data_type = "html"
    data.page = page - 1

    $.ajax({url: "/moodle/koolsoft/question/rest/index.php/",
        data: data,
        success: function(htmlResponse){

            // alert(htmlResponse)

            $("#question_list").empty()
            $("#question_list").html(htmlResponse);
        },
        error: function () {
            console.log("get question error !!!!!");
        }
    });
}