/**
 * Created by dddd on 12/22/16.
 */
var Ks = Ks || {};
Ks.questionTag = Ks.questionTag || {};

Ks.questionTag.init = function () {
    Ks.questionTag.handler();
    Ks.questionTag.loadQuestionTag();
};

Ks.questionTag.handler = function () {
    $("#showAddTagDialog").click(function () {
        $("#tagName").val("");
        $("#tagId").val("");
        $("#createTagDialogHeader").html("Create new tag");
        $("#btnAddTag").html("Add");
        $("#createTagDialog").modal();
    });

    $("#btnAddTag").click(function () {
        var id = $("#tagId").val();
        var name = $("#tagName").val();

        var data = {};
        data.action = "create";
        data.id = id;
        data.name = name;
        $.post({ url: "/moodle/koolsoft/question_tag/rest/question_tag.php",
            data: data,
            success: function(result){
                if(result){
                    var tag = JSON.parse(result);
                    if(tag.resultText == "Success"){
                        $("#createTagDialog").modal('hide');
                        Ks.questionTag.loadQuestionTag();
                        $("#createTagErrorText").css("display", "none");
                    }else {
                        $("#createTagErrorText").html(tag.resultText);
                        $("#createTagErrorText").css("display", "block");
                    }
                }
            }
        });
    });

    $("#btnConfirmDelete").click(function () {
        var data = {};
        data.id = $("#idObjectDelete").val();
        data.action = "delete";
        $.post({url: "/moodle/koolsoft/question_tag/rest/question_tag.php",
            data : data,
            success: function(result){
                $("#confirmDialogDelete").modal('hide');
                if(result){
                    Ks.questionTag.loadQuestionTag();
                }else {
                    $("#alertDialog").modal();
                    $("#alertContent").html("Can not delete tag!");
                }
            }});
    });
};

Ks.questionTag.loadQuestionTag = function () {
    $.ajax({url: "/moodle/koolsoft/question_tag/rest/question_tag.php?action=listAll",
        success: function(results){
            var tags = JSON.parse(results);
            var keys = Object.keys(tags);
            $("#idBodyTableTag").html("");
            for(var i = 0 ;  i < keys.length; i ++ ){
                Ks.questionTag.genTag(i + 1 ,tags[keys[i]], $("#idBodyTableTag"));
            }
        },
        error: function () {
            console.log("error !!!!!");
        }
    });
};

Ks.questionTag.genTag = function (no, tag, table) {
    console.log(tag);
    var idEdit = "edit" + new Date().getTime() + tag.id;
    var idDelete = "del" + new Date().getTime() + tag.id;
    var html = "";
    html += "<tr style='height: 50px;'>";
    html += "<td> " + no + "</td>";
    html += "<td>";
    html += "<a href='/moodle/koolsoft/question_categories/?action=show&id="+ tag.id + "'>";
    html += "<span class='glyphicon glyphicon-tag'> " + tag.name + "</span>";
    html += "</a>";
    html += "</td>";
    html += "<td>";
    html += "<div class='dropdown' style='display: inline-block; float: right;'>"
        + "<button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>"
        + "<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>"
        + "</button>"
        + "<ul class='dropdown-menu'>"
        + "<li id='" + idEdit + "' tag-id='" + tag.id + "' tag-name='" + tag.name + "'> <a> Edit </a> </li>"
        + "<li id='" + idDelete + "'tag-id='" + tag.id + "'> <a >Delete</a></li>"
        + "</ul> </div>";
    html += "</td>";

    table.append(html);

    $("#" + idEdit).click(function () {
        $("#tagName").val($(this).attr("tag-name"));
        $("#tagId").val($(this).attr("tag-id"));
        $("#createTagDialogHeader").html("Edit tag : " + $(this).attr("tag-name"));
        $("#btnAddTag").html("Edit");
        $("#createTagDialog").modal();
    });

    $("#" + idDelete).click(function () {
        $("#idObjectDelete").val($(this).attr("tag-id"));
        $("#confirmDialogDelete").modal();
    });
};


$(function () {
    Ks.questionTag.init();
});