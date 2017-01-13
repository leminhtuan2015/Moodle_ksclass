<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/13/17
 * Time: 12:13 AM
 */

global $CFG;
require_once(__DIR__."/../../../config.php");
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->dirroot . '/koolsoft/quiz/models/ks_quiz.php');
require_once($CFG->dirroot . '/koolsoft/test/models/ks_question_progress.php');
require_once($CFG->dirroot . '/koolsoft/question/models/ks_question.php');
require_once($CFG->dirroot . '/koolsoft/quiz/models/ks_quiz.php');
require_once($CFG->dirroot . '/koolsoft/utility/DateUtil.php');

class rest_exercise
{
    public function start(){
        global $USER;
        $quizId = required_param('quiz', PARAM_INT);
        $daoQuestionProgess = new ks_question_progress();
        $listQuestionProgress = $daoQuestionProgess->getByUserAndQuiz($USER->id, $quizId);
        if(! $listQuestionProgress || count($listQuestionProgress) == 0){
            $listQuestionProgress = $this->initQuestionProgress();
        }

    }

    public function initQuestionProgress($userId, $quizId){
        $listQuestionProgess = array();
        $daoQuiz = new ks_quiz();
        $daoQuestionProgress = new ks_question_progress();
        $slots = $daoQuiz->loadSlotsOnlyInQuiz($quizId);
        foreach ($slots as $slot){
            $questionProgess = $daoQuestionProgress->create($userId, $quizId, $slot->questionid, -1);
            array_push($listQuestionProgess, $questionProgess);
        }

        return $listQuestionProgess;
    }
}