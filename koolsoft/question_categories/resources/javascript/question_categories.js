/**
 * Created by dddd on 12/27/16.
 */

var Ks = Ks || {};
Ks.questionCategory = Ks.questionCategory || {};
Ks.questionCategory.categories = [];
Ks.questionCategory.headerText = "";
Ks.questionCategory.init = function () {
    Ks.questionCategory.loadCategory();
    Ks.questionCategory.handler();
    var categoryId = $("#categoryParentId").val();
    Ks.questionCategory.getHeader(categoryId);
};

Ks.questionCategory.getHeader = function (categoryId) {
    if(categoryId && categoryId > 0){
        $.ajax({url: "/moodle/koolsoft/question_categories/rest/question_categories.php?action=one&id=" + categoryId, success: function(result){
            var category = JSON.parse(result);
            Ks.questionCategory.headerText = "/ <a href='/moodle/koolsoft/question_categories/?action=show&id=" + category.id + "'>" + category.name + "</a>" + Ks.questionCategory.headerText;
            if(category.parent > 0){
                Ks.questionCategory.getHeader(category.parent);
            }else {
                Ks.questionCategory.headerText = "<a href='/moodle/koolsoft/question_categories/?action=show'>Library</a>" + Ks.questionCategory.headerText;
                $("#headerLibrary").html(Ks.questionCategory.headerText);
            }
        }});
    }else {
        Ks.questionCategory.headerText = "<a href='/moodle/koolsoft/question_categories/?action=show'>Library</a>" + Ks.questionCategory.headerText;
        $("#headerLibrary").html(Ks.questionCategory.headerText);
    }

};

Ks.questionCategory.handler = function () {
    $("#btnShowCreateCategoryDialog").click(function () {
        $("#createCategoryDialogHeader").html("Create new topic");
        $("#btnAddCategory").html("Create");
        $("#categoryId").val("");
        $("#categoryName").val("");
        $("#categoryInfor").val("");
        $("#createCategoryErrorText").css("display", "none");
        $("#createCategoryDialog").modal();
    });

    $("#btnAddCategory").click(function () {
        var categoryId = $("#categoryParentId").val();
        var id = $("#categoryId").val();
        var userId = $("#userId").val();
        var name = $("#categoryName").val();
        var info = $("#categoryInfor").val();

        var data = {};
        data.action = "create";
        data.id = id;
        data.categoryid = categoryId;
        data.userid = userId;
        data.name = name;
        data.info = info;
        data.type = 1;
        $.post({ url: "/moodle/koolsoft/question_categories/rest/question_categories.php",
            data: data,
            success: function(result){
                if(result){
                    var category = JSON.parse(result);
                    if(category.resultText == "Success"){
                        $("#createCategoryDialog").modal('hide');
                        Ks.questionCategory.loadCategory();
                        $("#createCategoryErrorText").css("display", "none");
                    }else {
                        $("#createCategoryErrorText").html(category.resultText);
                        $("#createCategoryErrorText").css("display", "block");
                    }
                }
            }
        });
    });

    $("#btnConfirmDelete").click(function () {
        var data = {};
        data.id = $("#idObjectDelete").val();
        data.action = "delete";
        $.post({url: "/moodle/koolsoft/question_categories/rest/question_categories.php",
            data : data,
            success: function(result){
                $("#confirmDialogDelete").modal('hide');
                if(result){
                    Ks.questionCategory.loadCategory();
                }else {
                    $("#alertDialog").modal();
                    $("#alertContent").html("Can not delete folder because forlder contain some exercise or folder!");
                }
            }});
    });
};

Ks.questionCategory.genCategories = function (categories) {
    $("#idBodyTableCategories").html("");
    var keys = Object.keys(categories);
    for(var i = 0; i < keys.length; i++){
        if(categories[keys[i]].type == 1){
            Ks.questionCategory.genCategory(categories[keys[i]], $("#idBodyTableCategories"));
        }if(categories[keys[i]].type == 2){
            Ks.questionCategory.genExercise(categories[keys[i]], $("#idBodyTableCategories"));
        }
    }
};

Ks.questionCategory.genCategory = function (category, table) {
    var idEdit = "edit" + new Date().getTime() + category.id;
    var idDelete = "del" + new Date().getTime() + category.id;
    var html = "";
    html += "<tr style='height: 50px;'>";
    html += "<td>";
    html += "<a href='/moodle/koolsoft/question_categories/?action=show&id="+ category.id + "'>";
    html += "<span class='glyphicon glyphicon-file'> " + category.name + "</span>";
    html += "</a>";
    html += "<div class='dropdown' style='display: inline-block; float: right;'>"
        + "<button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>"
        + "<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>"
        + "</button>"
        + "<ul class='dropdown-menu'>"
        + "<li id='" + idEdit + "' category-id='" + category.id + "' category-name='" + category.name + "' + category-info='" + category.info + "'> <a> Edit </a> </li>"
        + "<li id='" + idDelete + "'category-id='" + category.id + "'> <a >Delete</a></li>"
        + "</ul> </div>";
    html += "</td>";

    table.append(html);

    $("#" + idEdit).click(function () {
        $("#categoryName").val($(this).attr("category-name"));
        $("#categoryInfor").val($(this).attr("category-info"));
        $("#categoryId").val($(this).attr("category-id"));
        $("#createCategoryDialogHeader").html("Edit topic : " + $(this).attr("category-name"));
        $("#btnAddCategory").html("Edit");
        $("#createCategoryDialog").modal();
    });

    $("#" + idDelete).click(function () {
        $("#idObjectDelete").val($(this).attr("category-id"));
        $("#confirmDialogDelete").modal();
    });
};

Ks.questionCategory.genExercise = function (category, table) {
    var idDelete = "del" + new Date().getTime() + category.id;
    var html = "";
    html += "<tr style='height: 50px;'>";
    html += "<td>";
    html += "<a href='/moodle/koolsoft/question/?action=edit&category="+ category.id + "&returnUrl=" + encodeURIComponent(window.location.href) + "'>";
    html += "<span class='glyphicon glyphicon-list-alt'> " + category.name + "</span>";
    html += "</a>";
    html += "<div class='dropdown' style='display: inline-block; float: right;'>"
        + "<button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>"
        + "<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>"
        + "</button>"
        + "<ul class='dropdown-menu'>"
        + "<li id='btnShowCreateCategoryDialog'> <a href='/moodle/koolsoft/question/?action=edit&category="+ category.id+ "&returnUrl=" + encodeURIComponent(window.location.href) + "'> Edit </li>"
        + "<li category-id='" + category.id + "' id='" + idDelete + "'> <a >Delete</a></li>"
        + "</ul> </div>";
    html += "</td>";
    html += "</td>";
    table.append(html);

    $("#" + idDelete).click(function () {
        $("#idObjectDelete").val($(this).attr("category-id"));
        $("#confirmDialogDelete").modal();
    });
};

Ks.questionCategory.loadCategory = function () {
    var categoryId = $("#categoryParentId").val();
    var userId = $("#userId").val();

    if(categoryId && categoryId > 0){
        $.ajax({url: "/moodle/koolsoft/question_categories/rest/question_categories.php?action=list&categoryid=" + categoryId, success: function(results){
            Ks.questionCategory.genCategories(JSON.parse(results));
        }});
    }else if(userId && userId > 0){
        $.ajax({url: "/moodle/koolsoft/question_categories/rest/question_categories.php?action=list&userid=" + userId, success: function(results){
            Ks.questionCategory.genCategories(JSON.parse(results));
        }});
    }
};

$(function () {
    Ks.questionCategory.init();
});