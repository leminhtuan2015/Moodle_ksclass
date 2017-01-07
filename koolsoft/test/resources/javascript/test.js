/**
 * Created by dddd on 1/6/17.
 */
/**
 * Created by dddd on 12/22/16.
 */
var Ks = Ks || {};
Ks.test = Ks.test || {};
Ks.test.numberQuestion = 0;

Ks.test.init = function () {
    Ks.test.handler();
};

Ks.test.handler = function () {
    Ks.test.numberQuestion = $("#numberQuestion").val();
    for(var i = 1; i <= Ks.test.numberQuestion; i++){
        $("#questionBtn" + i).click(function () {
            Ks.test.showQuestion($(this).attr("indexQuestion"));
        });
    }
};

Ks.test.showQuestion = function (index) {
    for(var i = 1; i <= Ks.test.numberQuestion; i++){
        if(i == index){
            $("#questionDiv" + i).css("display", "block");
        }else {
            $("#questionDiv" + i).css("display", "none");
        }
    }
};

$(function () {
    Ks.test.init();
});