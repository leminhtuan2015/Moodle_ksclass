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
require_once($CFG->dirroot . '/koolsoft/test/models/ks_question_progress.php');
require_once($CFG->dirroot . '/koolsoft/question/models/ks_question.php');
require_once($CFG->dirroot . '/koolsoft/quiz/models/ks_quiz.php');
require_once($CFG->dirroot . '/koolsoft/utility/DateUtil.php');

class rest_exercise
{
    public function start(){
        global $USER;
        if(!$USER->id){
        	$userId     = required_param('user',  PARAM_INT);
        	$USER = new stdClass();
        	$USER->id = $userId;
        }
        
        $daoQuiz = new ks_quiz();
        $firstPlay = false;
        $quizId = required_param('quiz', PARAM_INT);
        $box = required_param('box', PARAM_INT);
        $quiz = $daoQuiz->loadOne($quizId);
        $daoQuestionProgess = new ks_question_progress();
        $listQuestionProgress = $daoQuestionProgess->getByUserAndQuiz($USER->id, $quizId);
        if(! $listQuestionProgress || count($listQuestionProgress) == 0){
            $listQuestionProgress = $this->initQuestionProgress($USER->id, $quizId);
            $firstPlay= true;
        }

        if($box == -1){
            $questions = $this->getQuestionRandom($listQuestionProgress, 10, $firstPlay);
        }else {
            $questions = $this->getQuestionInBox($quizId, $box, 10);
        }

        $quiz->questions = $this->arrangeAnswer($questions);

        echo json_encode($quiz);
    }

    public function play(){
        global $USER;
        if(!$USER->id){
        	$userId     = required_param('user',  PARAM_INT);
        	$USER = new stdClass();
        	$USER->id = $userId;
        }
        
        $daoQuestionProgress = new ks_question_progress();
        $quizId = required_param('quiz', PARAM_INT);
        $questionDataText = required_param('questionData', PARAM_TEXT);
        $questionDatas = json_decode($questionDataText);
        foreach ($questionDatas as $questionData){
            $daoQuestionProgress->update($USER->id, $quizId, $questionData->questionId, $questionData->fraction);
        }

        $this->getQuizOverview();
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

    public function getQuestionInBox($quizId, $box, $numberQuestion){
        global $USER;
        if(!$USER->id){
        	$userId     = required_param('user',  PARAM_INT);
        	$USER = new stdClass();
        	$USER->id = $userId;
        }
        
        $daoQuestionProgess = new ks_question_progress();
        $listQuestionProgress = $daoQuestionProgess->getByBox($USER->id, $quizId, $box, 0, $numberQuestion);
        $daoQuestion = new ks_question();
        $questionIds = array();
        foreach ($listQuestionProgress as $questionProgess){
            array_push($questionIds, $questionProgess->question_id);
        }
        $questions = $daoQuestion->getByIds($questionIds);

        return $questions;
    }

    // 50%: not answer; 30%: wrong; 20%
    public function getQuestionRandom($listQuestionProgress, $numberQuestion, $firstPlay){
        $daoQuestion = new ks_question();
        $questionIds = array();
        if($firstPlay || count($listQuestionProgress) <= $numberQuestion){
            foreach ($listQuestionProgress as $questionProgess){
                array_push($questionIds, $questionProgess->question_id);
            }
        }else {
            $listQuestionProgressResult = array();
            $listQuestionProgressF = array();
            $numberQuestionNo = $numberQuestion * 0.5;
            $numberQuestionWrong = $numberQuestion * 0.3;
            $numberQuestionN = $numberQuestion * 0.2;

            $boxNo = array();
            $boxWrong = array();
            $boxn = array();
            foreach ($listQuestionProgress as $questionProgess){
                if($questionProgess->box == -1){
                    array_push($boxNo, $questionProgess);
                }else if($questionProgess->box == 0){
                    array_push($boxWrong, $questionProgess);
                }else if($questionProgess->box >= 1){
                    array_push($boxn, $questionProgess);
                }
            }

            if(count($boxNo) > $numberQuestionNo){
                $listQuestionProgressResult = array_merge($listQuestionProgressResult, array_splice($boxNo, 0, $numberQuestionNo));
                $numberQuestionNo = 0;
                $listQuestionProgressF = array_merge($listQuestionProgressF, $boxNo);
            }else {
                $numberQuestionNo = $numberQuestionNo - count($boxNo);
                $listQuestionProgressResult = array_merge($listQuestionProgressResult, array_splice($boxNo, 0, count($boxNo)));
            }

            if(count($boxWrong) > $numberQuestionWrong){
                $listQuestionProgressResult = array_merge($listQuestionProgressResult, array_splice($boxWrong, 0, $numberQuestionWrong));
                $numberQuestionWrong = 0;
                $listQuestionProgressF = array_merge($listQuestionProgressF, $boxWrong);
            }else {
                $numberQuestionWrong = $numberQuestionWrong - count($boxWrong);
                $listQuestionProgressResult = array_merge($listQuestionProgressResult, array_splice($boxWrong, 0, count($boxWrong)));
            }

            if(count($boxn) > $numberQuestionN){
                $listQuestionProgressResult = array_merge($listQuestionProgressResult, array_splice($boxn, 0, $numberQuestionN));
                $numberQuestionN = 0;
                $listQuestionProgressF = array_merge($listQuestionProgressF, $boxn);
            }else {
                $numberQuestionN = $numberQuestionN - count($boxn);
                $listQuestionProgressResult = array_merge($listQuestionProgressResult, array_splice($boxn, 0, count($boxn)));
            }

            $numberQuestionF = $numberQuestionNo + $numberQuestionN + $numberQuestionWrong;
            if($numberQuestionF > 0){
                $listQuestionProgressResult = array_merge($listQuestionProgressResult, array_splice($listQuestionProgressF, 0, $numberQuestionF));
            }

            foreach ($listQuestionProgressResult as $questionProgess){
                array_push($questionIds, $questionProgess->question_id);
            }
        }

        $questions = $daoQuestion->getByIds($questionIds);

        return $questions;
    }

    public function arrangeAnswer($questions){
        $questionArranges = array();
        $index = 1;
        foreach ($questions as $question){
            $questionArrange = new stdClass();
            $answerArranges = array();
            $questionArrange->id = $question->id;
            $questionArrange->questiontext = $question->questiontext;

            $answers = $question->options->answers;
            shuffle($answers);
            foreach ($answers as $answer){
                $answerArrange = new stdClass();
                if($answer->fraction > 0){
                    $questionArrange->answerCorrect = $answer->answer;
                    $answerArrange->correct = true;
                }else {
                    $answerArrange->correct = false;
                }

                $answerArrange->idAnswer = $answer->id;

                $answerArrange->answer = $answer->answer;
                array_push($answerArranges, $answerArrange);
            }

            $questionArrange->index = $index;
            $questionArrange->answers = $answerArranges;
            if($index != 1){
                $questionArrange->display = false;
            }else {
                $questionArrange->display = true;
            }
            array_push($questionArranges, $questionArrange);

            $index ++;
        }

        return $questionArranges;
    }

    public function getQuizOverview(){
        global $USER;
        if(!$USER->id){
        	$userId     = required_param('user',  PARAM_INT);
        	$USER = new stdClass();
        	$USER->id = $userId;
        }
        
        $quizId = required_param('quiz', PARAM_INT);
        $daoQuiz = new ks_quiz();
        $daoQuestionProgress = new ks_question_progress();
        $listQuestionProgress = $daoQuestionProgress->getByUserAndQuiz($USER->id, $quizId);
        if(! $listQuestionProgress || count($listQuestionProgress) == 0){
            $listQuestionProgress = $this->initQuestionProgress($USER->id, $quizId);
        }

        $boxNo = array();
        $boxWrong = array();
        $box1 = array();
        $box2 = array();
        $box3 = array();
        $boxN = array();

        foreach ($listQuestionProgress as $questionProgess){
            if($questionProgess->box == -1){
                array_push($boxNo, $questionProgess);
            }else if($questionProgess->box == 0){
                array_push($boxWrong, $questionProgess);
            }else if($questionProgess->box == 1){
                array_push($box1, $questionProgess);
            }else if($questionProgess->box == 2){
                array_push($box2, $questionProgess);
            }else if($questionProgess->box == 3){
                array_push($box3, $questionProgess);
            }else if($questionProgess->box >= 4){
                array_push($boxN, $questionProgess);
            }
        }

        $questionBox1 = $this->getQuestionByProgress($box1);
        $questionBox2 = $this->getQuestionByProgress($box2);
        $questionBox3 = $this->getQuestionByProgress($box3);
        $questionBoxN = $this->getQuestionByProgress($boxN);
        $questionBoxNo = $this->getQuestionByProgress($boxNo);
        $questionBoxWrong = $this->getQuestionByProgress($boxWrong);

        $quiz = $daoQuiz->loadOne($quizId);
        $quiz->boxNo = count($boxNo);
        $quiz->boxWrong = count($boxWrong);
        $quiz->box1 = count($box1);
        $quiz->box2 = count($box2);
        $quiz->box3 = count($box3);
        $quiz->boxN = count($boxN);
        $quiz->questionBox1 = $questionBox1;
        $quiz->questionBox2 = $questionBox2;
        $quiz->questionBox3 = $questionBox3;
        $quiz->questionBoxN = $questionBoxN;
        $quiz->questionBoxNo = $questionBoxNo;
        $quiz->questionBoxWrong = $questionBoxWrong;

        echo json_encode($quiz);
    }

    public function getQuestionByProgress($listQuestionProgress){
        $daoQuestion = new ks_question();
        $questions = array();
        $index = 1;
        foreach ($listQuestionProgress as $questionProgess){
            $question = $daoQuestion->getByIdOnlyOption($questionProgess->question_id);
            if($questionProgess->hitory){
                $historyArray = explode( ',', $questionProgess->history);
                if($historyArray){
                    $question->history = array_splice($historyArray, 0, 5);
                }
            }
            $answers = $question->options->answers;
            if($answers){
                foreach ($answers as $answer){
                    if($answer->fraction > 0){
                        $question->answertext = $answer->answer;
                    }
                }
            }
            $question->index = $index;
            array_push($questions, $question);
            $index ++;
        }

        return $questions;
    }
}