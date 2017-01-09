<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/9/17
 * Time: 10:09 AM
 */

require_once("../../../config.php");
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->dirroot . '/koolsoft/quiz/models/ks_quiz.php');
require_once($CFG->dirroot . '/koolsoft/question/models/ks_question.php');

global $DB;
$dao = new ks_question();

// action add, update, list, delete
$action = optional_param('action', "", PARAM_TEXT);
global $USER;
switch ($action) {
    case "loadForPlay":
        $daoQuestion = new ks_question();
        $daoQuiz = new ks_quiz();
        $id = optional_param("id", 0, PARAM_INT);
        $attempt = $DB->get_record("quiz_attempts", array("id" => $id));
        $quiz = $daoQuiz->loadOne($attempt->quiz);
        $quizName = $quiz->name;
        $attemptobj = quiz_attempt::create($id);
        $slots = $daoQuiz->loadSlotsInQuiz($attempt->quiz);
        $questionIds = array();
        $sequenceChecks = array();
        $slotString = "";
        $indexSlot = 0;
        foreach ($slots as $slot){
            $question_attempts = $attemptobj->all_question_attempts_originally_in_slot($slot->slot);
            $question_attempt = $question_attempts[0];
            array_push($sequenceChecks, $question_attempt->get_sequence_check_count());
            array_push($questionIds, $slot->questionid);
            if($indexSlot == 0){
                $slotString .= $slot->slot;
            }else {
                $slotString .= ",".$slot->slot;
            }
            $indexSlot ++;
        }

        $questions = $daoQuestion->loadByIds($questionIds);
        $attempt->questions = $questions;
        $attempt->sequenceChecks = $sequenceChecks;
        $attempt->slotString = $slotString;
        $attempt->quiz = $quiz;
        echo json_encode($attempt);
        break;

    case "preForPlay":
        global $USER;
        // Get submitted parameters.
        $id = required_param('cmid', PARAM_INT); // Course module id
        $forcenew = optional_param('forcenew', true, PARAM_BOOL); // Used to force a new preview
        $newTest = optional_param('newTest', false, PARAM_BOOL); // Used to trick force a new preview by dungdv
        $page = optional_param('page', -1, PARAM_INT); // Page to jump to in the attempt.

        if (!$cm = get_coursemodule_from_id('quiz', $id)) {
            print_error('invalidcoursemodule');
        }

        if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
            print_error("coursemisconf");
        }

        $quizobj = quiz::create($cm->instance, $USER->id);

        // Create an object to manage all the other (non-roles) access rules.
        $timenow = time();
        $accessmanager = $quizobj->get_access_manager($timenow);

        // Validate permissions for creating a new attempt and start a new preview attempt if required.
        list($currentattemptid, $attemptnumber, $lastattempt, $messages, $page) =
            quiz_validate_new_attempt($quizobj, $accessmanager, $forcenew, $page, true);

        $attemptNews = quiz_get_user_attempts($quizobj->get_quizid(), $USER->id, 'all', true);
        $lastattemptNew = end($attemptNews);

        if ($lastattemptNew && $lastattemptNew->state == quiz_attempt::FINISHED && !$newTest) {
            $result = new stdClass();
            $result->status = "done";
            $result->id = $lastattemptNew->id;
            echo json_encode($result);
        }else {
            $attempt = quiz_prepare_and_start_new_attempt($quizobj, $attemptnumber, $lastattempt);
            $result = new stdClass();
            $result->status = "start";
            $result->id = $attempt->id;
            echo json_encode($result);
        }

        break;

    case "loadTestResult":

        $attemptid = required_param('id',  PARAM_INT);
        $page      = optional_param('page', 0, PARAM_INT);
        $showall   = optional_param('showall', true, PARAM_BOOL);

        $attemptobj = quiz_attempt::create($attemptid);
        $page = $attemptobj->force_page_number_into_range($page);
        $questionids = $attemptobj->get_slots();

        // Summary table start. ============================================================================

        // Work out some time-related things.
        $attempt = $attemptobj->get_attempt();
        $quiz = $attemptobj->get_quiz();
        $overtime = 0;

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

        $options = $attemptobj->get_display_options(true);

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

        if ($showall) {
            $slots = $attemptobj->get_slots();
            $lastpage = true;
        } else {
            $slots = $attemptobj->get_slots($page);
            $lastpage = $attemptobj->is_last_page($page);
        }

        foreach ($slots as $slot){
            $data = $attemptobj->get_question_attempt($slot)->get_question();

        }

        $daoQuiz = new ks_quiz();
        $quiz = $daoQuiz->loadOne($attempt->quiz);
        $quizName = $quiz->name;
        $courseId = $quiz->course;

        $reviewData = new stdClass();
        $reviewData->quizName = $quizName;
        $reviewData->quizId = $quiz->id;
        $reviewData->summarydata = $summarydata;

        echo json_encode($reviewData);
        break;

}
