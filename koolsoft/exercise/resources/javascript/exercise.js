/**
 * Created by dddd on 1/13/17.
 */

var Ks = Ks || {};
Ks.exercise = Ks.exercise || {};
Ks.exercise.numberQuestion = 0;
Ks.exercise.idExerciseCurrent = null;
Ks.exercise.idExerciseInstanceCurrent = null;
Ks.exercise.idSectionCurrent = null;
Ks.exercise.exercisePanelCurrent = null;

Ks.exercise.init = function () {
    Ks.test.handler();
};

Ks.exercise.handler = function () {

};

Ks.exercise.showQuestion = function (index) {

};

Ks.exercise.genPlayView = function (attempt, questionPanel){

};

Ks.exercise.genReviewView = function (reviewData, questionPanel){


};

$(function () {
    $(".showExerciseBtn").click(function () {
        Ks.exercise.idExerciseCurrent = $(this).attr("id-quiz");
        Ks.exercise.idExerciseInstanceCurrent = $(this).attr("id-quiz-instance");
        Ks.exercise.idSectionCurrent = $(this).attr("id-section");
        Ks.exercise.exercisePanelCurrent = $($(this).attr("href"));

    });
    Ks.test.init();
});
