<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/6/17
 * Time: 1:41 PM
 */
	global $CFG;
	include($CFG->dirroot.'/koolsoft/quiz/views/templates/quiz.html');
?>
<script src="/moodle/koolsoft/quiz/resources/javascript/quiz.js"></script>
<div id="createQuizDialog" class="modal fade" role="dialog" style="overflow-y: auto;">
    <div class="modal-dialog" style="width: 90%">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <button type="button submit" class="btn btn-primary" style="float: right;margin-right: 10px;" form="formQuiz" id="saveQuiz">Save</button>
                <h4 class="modal-title">Create quiz</h4>
            </div>
            <div class="modal-body" style="overflow: hidden">
                <form data-toggle="validator" role="form" action="/moodle/koolsoft/quiz/?action=save" method="post" id="formQuiz">
                    <div style="display: none" class="form-group">
                        <input id="idQuiz" name="idQuiz" value="">
                        <input id="idSection" name="idSection" value="">
                        <input id="course" name="course" value="<?php echo $course->id;?>">
                        <input id="saveAction" name="saveAction" value="saveQuiz">
                        <input id="idQuestions" name="idQuestions" value="">
                        <input id="idSlotRemoves" name="idSlotRemoves" value="">
                    </div>
                    <div >
                        <div style="display: inline-block; width: 49%">
                            <label for="nameQuiz" class="control-label" style="display: inline-block;width: 20%;">Name</label>
                            <input style="display: inline-block;width: 79%;" required id="nameQuiz" placeholder="quiz name" class="form-control" <?php if($currentQuiz){ echo 'disabled';}?> name="nameQuiz" value="<?php if($currentQuiz){ echo $currentQuiz->name;}?>">
                        </div>
                        <div style="display: inline-block; width: 49%">
                            <label for="descQuiz" style="display: inline-block;width: 20%;" class="control-label">Description</label>
                            <input required id="descQuiz" style="display: inline-block;width: 79%;" placeholder="quiz description" class="form-control" <?php if($currentQuiz){ echo 'disabled';}?> name="descQuiz" value="<?php if($currentQuiz){ echo $currentQuiz->intro;}?>">
                        </div>
                    </div>
                    <br>
                    <div >
                        <div style="display: inline-block; width: 49%;">
                            <label style="display: inline-block; width: 20%;" >Chapter:</label>
                            <select style="display: inline-block; width: 79%;" class="form-control" id="chapterSelect">
                                <?php foreach ($sections as $sectionChapter) { ?>
                                    <?php if($sectionChapter->section == 0){continue;} ?>
                                    <?php if($sectionChapter->parent_id == 0){ ?>
                                        <option value="<?php echo "$sectionChapter->id"?>"> <?php echo "$sectionChapter->name"?> </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div style="display: inline-block; width: 49%;">
                            <label style="display: inline-block;width: 20%;" >Lecture:</label>
                            <select style="display: inline-block; width: 79%;" class="form-control" name="section" id="lectureSelect">

                            </select>
                        </div>
                    </div>
                    <br>
                    <div >
                        <div style="display: inline-block; width: 49%">
                            <label style="display: inline-block;vertical-align: middle;width: 20%;">Type</label>
                            <select style="display: inline-block; width: 79%;" class="form-control" name="typeQuiz" id="typeQuizSelect">
                                <option value="1"> Exercise </option>
                                <option value="2"> Test </option>
                            </select>
                        </div>
                        <div style="display: inline-block; width: 49%" id="timeLimitPanel">
                            <label style="display: inline-block;vertical-align: middle;width: 20%;">Time limit( mins)</label>
                            <input type="number" min="0" step="1" style="display: inline-block; width: 79%;" class="form-control" name="timeLimit" id="timeLimit">
                        </div>
                    </div>
                    <br>
                    <div style="margin-bottom: 20px;" id="timeQuizPanel">
                        <div style="display: inline-block; width: 49%">
                            <label style="display: inline-block;vertical-align: middle;width: 20%;">Time start</label>
                            <div style="width: 79%; display: inline-block;vertical-align: middle;">
                                <div class='input-group date' id='datetimepickerStart'>
                                    <input name="startTime" id="startTime" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div style="display: inline-block;  width: 49%">
                            <label style="display: inline-block;vertical-align: middle;width: 20%;">Time end</label>
                            <div style="width: 79%; display: inline-block;vertical-align: middle;">
                                <div class='input-group date' id='datetimepickerEnd'>
                                    <input name="endTime" id="endTime" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <label style="float: right; margin-right: 2%;" id="error_end_time" class="control-label text-danger"></label>
                    </div>

                </form>
                    <div id="questionMainPanel" style="overflow: hidden; width = 100%;">
                        <div style="display: inline-block;" class="col-md-3">
                            <div class="navbar-collapse collapse sidebar-navbar-collapse">
                                <ul class="nav navbar-nav" style="width: 100%;">
                                    <ul class="nav nav-pills brand-pills nav-stacked" role="tablist" style="height: 400px; border-radius: 6px; overflow-y: scroll;" id="listQuestion">
                                    </ul>

                                </ul>
                            </div>
                            <br>
                            <br>

                        </div>
                        <div style="display: inline-block; border-radius: 6px;" class="col-md-9" id="questionDetail">

                            <div id="questionDiv">

                            </div>
                           
                            <div class="form-group">

                                <label style="display: none; color: #ff5f50;" id="createQuestionErrorText"></label>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" style="display: none;" id="saveOneQuestionBtn">Save</button>
                                <button class="btn btn-danger" style="display: none;" id="removeOneQuestionBtn">Remove</button>
                            </div>
                            <br>

                        </div>
                    </div>
                <div style="margin-left: 3%; width: 30%; overflow: hidden;">
                    <a style="float:left; margin-right: 15px;" class="blue"  id="btnAddQuestionNew">Add new</a>
                    <br>
                    or
                    <br>
                    <a style="float:left; margin-right: 15px;" class="blue"  id="btnAddQuestion">Add form library</a>
                </div>
            </div>
            <div class="modal-footer">
                <br>
            </div>
        </div>

    </div>
</div>