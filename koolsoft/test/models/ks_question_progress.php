<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/23/16
 * Time: 10:03 PM
 */
global $CFG;
require_once($CFG->dirroot."/config.php");
require_once($CFG->dirroot."/koolsoft/utility/DateUtil.php");
class ks_question_progress
{
   public function getByUser($userId, $quizId, $questionId){
       global $DB;
       $questionProgess = $DB->get_record("question_progress", array("quiz_id"=> $quizId, "question_id"=> $questionId, "user_id" => $userId));
       if(!$questionProgess){
            $this->create($userId, $quizId, $questionId, -1);
       }

       return $questionProgess;
    }

    public function create($userId, $quizId, $questionId, $box){
        global $DB;
        $questionProgess = new stdClass();
        $questionProgess->user_id = $userId;
        $questionProgess->question_id = $questionId;
        $questionProgess->quiz_id = $quizId;
        $questionProgess->box = $box;
        $questionProgess->id = $DB->insert_record("question_progress", $questionProgess);
        return $questionProgess;
    }

    public function update($userId, $quizId, $questionId, $faction){
        global $DB;
        $questionProgess = $this->getByUser($userId, $quizId, $questionId);

        $questionProgess->last_result = $faction;
        $historyArray = explode( ',', $questionProgess->history);
        if($faction > 0){
            array_push($historyArray, 1);
        }else {
            array_push($historyArray, 0);
        }
        $questionProgess->history = implode(",", $historyArray);

        $countRightAnswer = 0;
        foreach ($historyArray as $history){
            if($history == 1){
                $countRightAnswer += 1;
            }
        }
        $questionProgess->box = $countRightAnswer;

        $DB->update_record("question_progress", $questionProgess);
    }

    public function getByUserAndQuiz($userId, $quizId){
        global $DB;
        $questionProgess = $DB->get_records("question_progress", array("quiz_id"=> $quizId, "user_id" => $userId, "sort"=> "box DESC"));
        return $questionProgess;
    }

}