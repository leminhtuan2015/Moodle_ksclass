<?php

/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/5/17
 * Time: 9:36 AM
 */

require_once(__DIR__."/../../config.php");
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once(__DIR__."/../application/ApplicationController.php");
require_once($CFG->dirroot . '/koolsoft/quiz/models/ks_quiz.php');
require_once($CFG->dirroot . '/koolsoft/test/models/QuestionProgress.php');
require_once($CFG->dirroot . '/koolsoft/question/models/ks_question.php');
class TestController extends ApplicationController
{
    function __construct() {
//        parent::__construct();
    }

    public function submitPlay(){
        global $USER;
        $daoQuestionProgress = new QuestionProgress();
        $timenow = time();

        $attemptid     = required_param('attempt',  PARAM_INT);
        $thispage      = optional_param('thispage', 0, PARAM_INT);
        $nextpage      = optional_param('nextpage', 0, PARAM_INT);
        $previous      = optional_param('previous',      false, PARAM_BOOL);
        $next          = optional_param('next',          false, PARAM_BOOL);
        $finishattempt = optional_param('finishattempt', false, PARAM_BOOL);
        $timeup        = optional_param('timeup',        0,      PARAM_BOOL); // True if form was submitted by timer.
        $scrollpos     = optional_param('scrollpos',     '',     PARAM_RAW);

        $attemptobj = quiz_attempt::create($attemptid);
        $status = $attemptobj->process_attempt($timenow, $finishattempt, $timeup, $thispage);
        $slots = $attemptobj->get_slots();
        foreach ($slots as $slot){
            $questionAttempt = $attemptobj->get_question_attempt($slot);
            $daoQuestionProgress->save($USER->id, $questionAttempt->get_question()->id, $questionAttempt->get_fraction());
        }

        return  true;
    }

    public function startPlay(){
        global $USER, $DB;
        // Get submitted parameters.
        $id = required_param('cmid', PARAM_INT); // Course module id
        $forcenew = optional_param('forcenew', false, PARAM_BOOL); // Used to force a new preview
        $page = optional_param('page', -1, PARAM_INT); // Page to jump to in the attempt.

        if (!$cm = get_coursemodule_from_id('quiz', $id)) {
            print_error('invalidcoursemodule');
        }

        if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
            print_error("coursemisconf");
        }

        $quizobj = quiz::create($cm->instance, $USER->id);




        $attempt = $DB->get_record("quiz_attempts", array("userid" => $USER->id, "quiz" => $quizobj->get_quizid()));
        if ($attempt && $attempt->state == quiz_attempt::FINISHED && !$forcenew) {
            $result = new stdClass();
            $result->status = "done";
            $result->id = $attempt->id;
            return $result;
        }else {
            $forcenew = true;
            // Create an object to manage all the other (non-roles) access rules.
            $timenow = time();
            $accessmanager = $quizobj->get_access_manager($timenow);

            // Validate permissions for creating a new attempt and start a new preview attempt if required.
            list($currentattemptid, $attemptnumber, $lastattempt, $messages, $page) =
                quiz_validate_new_attempt($quizobj, $accessmanager, $forcenew, $page, true);

            $attempt = quiz_prepare_and_start_new_attempt($quizobj, $attemptnumber, $lastattempt);
            $result = new stdClass();
            $result->status = "start";
            $result->id = $attempt->id;
            return $result;
        }
    }

    public function loadForPlay($id){
        global $DB;
        $daoQuestion = new ks_question();
        $daoQuiz = new ks_quiz();
        $attempt = $DB->get_record("quiz_attempts", array("id" => $id));
        $quiz = $daoQuiz->loadOne($attempt->quiz);
        $quizName = $quiz->name;
        $attemptobj = quiz_attempt::create($id);
        $slots = $daoQuiz->loadSlotsInQuiz($attempt->quiz);
        $sequenceChecks = array();
        $slotString = "";
        $indexSlot = 0;
        $questions = array();
        foreach ($slots as $slot){
            $question_attempts = $attemptobj->all_question_attempts_originally_in_slot($slot->slot);
            $orderAnswer = $attemptobj->get_question_attempt($slot->slot)->get_step(0)->get_all_data();
            $question = $attemptobj->get_question_attempt($slot->slot)->get_question();
            $answerIds = explode( ',',$orderAnswer["_order"]);
            $answers = array();
            $answerNoOrders = $question->answers;
            foreach ($answerIds as $answerId){
                array_push($answers, $answerNoOrders[$answerId]);
            }
            $question->answers = $answers;
            array_push($questions, $question);

            $question_attempt = $question_attempts[0];
            array_push($sequenceChecks, $question_attempt->get_sequence_check_count());
            if($indexSlot == 0){
                $slotString .= $slot->slot;
            }else {
                $slotString .= ",".$slot->slot;
            }
            $indexSlot ++;
        }

        $attempt->questions = $questions;
        $attempt->sequenceChecks = $sequenceChecks;
        $attempt->slotString = $slotString;
        $attempt->quiz = $quiz;

        return $attempt;
    }

    public function loadResult($attemptid){

        global  $DB, $USER;
        $page      = optional_param('page', 0, PARAM_INT);
        $showall   = optional_param('showall', true, PARAM_BOOL);

        $attemptobj = quiz_attempt::create($attemptid);
        $page = $attemptobj->force_page_number_into_range($page);
        $questionids = $attemptobj->get_slots();

        // Summary table start. ============================================================================

        // Work out some time-related things.
        $attempt = $attemptobj->get_attempt();
        $quiz = $attemptobj->get_quiz();
        $options = $attemptobj->get_display_options(true);

        $slots = $attemptobj->get_slots();
        $questions = array();

        foreach ($slots as $slot){
            $questionAttempt = $attemptobj->get_question_attempt($slot);
            $choiceAnswerObject = $questionAttempt->get_step(1)->get_all_data();
            $orderAnswer = $questionAttempt->get_step(0)->get_all_data();
            $question = $questionAttempt->get_question();
            $answerIds = explode( ',',$orderAnswer["_order"]);
            $choiceAnswer = $choiceAnswerObject["answer"];
            $answers = array();
            $answerNoOrders = $question->answers;
            $indexAnswer = 0;
            foreach ($answerIds as $answerId){
                $answer = $answerNoOrders[$answerId];
                if($indexAnswer == $choiceAnswer){
                    $answer->answered = true;
                }

                if($answer->fraction > 0){
                    $answer->correct = true;
                }
                array_push($answers, $answer);
                $indexAnswer ++;
            }
            $question->answers = $answers;
            array_push($questions, $question);
        }

        if ($attempt->state == quiz_attempt::FINISHED) {
            if ($timetaken = ($attempt->timefinish - $attempt->timestart)) {
                if ($quiz->timelimit && $timetaken > ($quiz->timelimit + 60)) {
                    $overtime = $timetaken - $quiz->timelimit;
                    $overtime = format_time($overtime);
                }
                $timetaken = format_time($timetaken);
            } else {
                $timetaken = "-";
            }
        } else {
            $timetaken = get_string('unfinished', 'quiz');
        }

        // Prepare summary informat about the whole attempt.
        $summarydata = array();
        if (!$attemptobj->get_quiz()->showuserpicture && $attemptobj->get_userid() != $USER->id) {
            // If showuserpicture is true, the picture is shown elsewhere, so don't repeat it.
            $student = $DB->get_record('user', array('id' => $attemptobj->get_userid()));
            $userpicture = new user_picture($student);
            $userpicture->courseid = $attemptobj->get_courseid();
            $summarydata['user'] = array(
                'title'   => $userpicture,
                'content' => new action_link(new moodle_url('/user/view.php', array(
                    'id' => $student->id, 'course' => $attemptobj->get_courseid())),
                    fullname($student, true)),
            );
        }

        if ($attemptobj->has_capability('mod/quiz:viewreports')) {
            $attemptlist = $attemptobj->links_to_other_attempts($attemptobj->review_url(null, $page,
                $showall));
            if ($attemptlist) {
                $summarydata['attemptlist'] = array(
                    'title'   => get_string('attempts', 'quiz'),
                    'content' => $attemptlist,
                );
            }
        }

        // Timing information.
        $summarydata['startedon'] = array(
            'title'   => get_string('startedon', 'quiz'),
            'content' => userdate($attempt->timestart),
        );

        $summarydata['state'] = array(
            'title'   => get_string('attemptstate', 'quiz'),
            'content' => quiz_attempt::state_name($attempt->state),
        );

        if ($attempt->state == quiz_attempt::FINISHED) {
            $summarydata['completedon'] = array(
                'title'   => get_string('completedon', 'quiz'),
                'content' => userdate($attempt->timefinish),
            );
            $summarydata['timetaken'] = array(
                'title'   => get_string('timetaken', 'quiz'),
                'content' => $timetaken,
            );
        }

        if (!empty($overtime)) {
            $summarydata['overdue'] = array(
                'title'   => get_string('overdue', 'quiz'),
                'content' => $overtime,
            );
        }

     // Show marks (if the user is allowed to see marks at the moment).
        $grade = quiz_rescale_grade($attempt->sumgrades, $quiz, false);
        if ($options->marks >= question_display_options::MARK_AND_MAX && quiz_has_grades($quiz)) {

            if ($attempt->state != quiz_attempt::FINISHED) {
                // Cannot display grade.

            } else if (is_null($grade)) {
                $summarydata['grade'] = array(
                    'title'   => get_string('grade', 'quiz'),
                    'content' => quiz_format_grade($quiz, $grade),
                );

            } else {
                // Show raw marks only if they are different from the grade (like on the view page).
                if ($quiz->grade != $quiz->sumgrades) {
                    $a = new stdClass();
                    $a->grade = quiz_format_grade($quiz, $attempt->sumgrades);
                    $a->maxgrade = quiz_format_grade($quiz, $quiz->sumgrades);
                    $summarydata['marks'] = array(
                        'title'   => get_string('marks', 'quiz'),
                        'content' => get_string('outofshort', 'quiz', $a),
                    );
                }

                // Now the scaled grade.
                $a = new stdClass();
                $a->grade = html_writer::tag('b', quiz_format_grade($quiz, $grade));
                $a->maxgrade = quiz_format_grade($quiz, $quiz->grade);
                if ($quiz->grade != 100) {
                    $a->percent = html_writer::tag('b', format_float(
                        $attempt->sumgrades * 100 / $quiz->sumgrades, 0));
                    $formattedgrade = get_string('outofpercent', 'quiz', $a);
                } else {
                    $formattedgrade = get_string('outof', 'quiz', $a);
                }
                $summarydata['grade'] = array(
                    'title'   => get_string('grade', 'quiz'),
                    'content' => $formattedgrade,
                );
            }
        }

        // Any additional summary data from the behaviour.
        $summarydata = array_merge($summarydata, $attemptobj->get_additional_summary_data($options));

        // Feedback if there is any, and the user is allowed to see it now.
        $feedback = $attemptobj->get_overall_feedback($grade);
        if ($options->overallfeedback && $feedback) {
            $summarydata['feedback'] = array(
                'title'   => get_string('feedback', 'quiz'),
                'content' => $feedback,
            );
        }

        // Summary table end. ==============================================================================

        $attempt->questions= $questions;
        $attempt->summarydata = $summarydata;
        $attempt->quiz = $quiz;


//        $daoQuiz = new ks_quiz();
//        $quiz = $daoQuiz->loadOne($attempt->quiz);
//        $quizName = $quiz->name;
//        $courseId = $quiz->course;
//
        $reviewData = new stdClass();
//        $reviewData->quizName = $quizName;
//        $reviewData->quizId = $quiz->id;
//        $reviewData->summarydata = $summarydata;
        return $attempt;

    }
}

