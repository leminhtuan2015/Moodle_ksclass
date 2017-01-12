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
class QuestionProgress
{
   public function getByUser($userId, $questionId){
       global $DB;
       $questionProgess = $DB->get_record("question_progress", array("question_id"=> $questionId, "user_id" => $userId));
       if(!$questionProgess){
           $questionProgess = new stdClass();
           $questionProgess->user_id = $userId;
           $questionProgess->question_id = $questionId;
           $questionProgess->id = $DB->insert_record("question_progress", $questionProgess);
       }

       return $questionProgess;
    }

    public function save($userId, $questionId, $faction){
        global $DB;
        $questionProgess = $this->getByUser($userId, $questionId);

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
}