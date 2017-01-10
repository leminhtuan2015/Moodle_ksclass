<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/6/17
 * Time: 1:41 PM
 */
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
                <form data-toggle="validator" role="form" action="/moodle/koolsoft/quiz/?action=edit&course=<?php echo $course->id;?>" method="post" id="formQuiz">
                    <div style="display: none" class="form-group">
                        <input id="idQuiz" name="idQuiz" value="">
                        <input id="idSection" name="idSection" value="">
                        <input id="saveAction" name="saveAction" value="saveQuiz">
                        <input id="idQuestions" name="idQuestions" value="">
                        <input id="idSlotRemoves" name="idSlotRemoves" value="">
                    </div>
                    <div class="form-group">
                        <div style="display: inline-block; width: 49%">
                            <label for="nameQuiz" class="control-label">Name</label>
                            <input required id="nameQuiz" placeholder="quiz name" class="form-control" <?php if($currentQuiz){ echo 'disabled';}?> name="nameQuiz" value="<?php if($currentQuiz){ echo $currentQuiz->name;}?>">
                        </div>
                        <div style="display: inline-block; width: 49%">
                            <label for="descQuiz" class="control-label">Description</label>
                            <input required id="descQuiz" placeholder="quiz description" class="form-control" <?php if($currentQuiz){ echo 'disabled';}?> name="descQuiz" value="<?php if($currentQuiz){ echo $currentQuiz->intro;}?>">
                        </div>
                    </div>

                    <div >
                        <div style="display: inline-block; width: 48%;">
                            <label style="display: inline-block" >Chapter:</label>
                            <select style="display: inline-block; width: 50%;" class="form-control" id="chapterSelect">
                                <?php foreach ($sections as $sectionChapter) { ?>
                                    <?php if($sectionChapter->section == 0){continue;} ?>
                                    <?php if($sectionChapter->parent_id == 0){ ?>
                                        <option value="<?php echo "$sectionChapter->id"?>"> <?php echo "$sectionChapter->name"?> </option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>

                        <div style="display: inline-block; width: 48%;">
                            <label style="display: inline-block" >Lecture:</label>
                            <select style="display: inline-block; width: 50%;" class="form-control" name="section" id="lectureSelect">

                            </select>
                        </div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <div style="display: inline-block; width: 49%">
                            <label style="display: inline-block;vertical-align: middle;">Time start</label>
                            <div style="width: 48%; display: inline-block;vertical-align: middle;">
                                <div class='input-group date' id='datetimepickerStart'>
                                    <input name="startTime" id="startTime" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div style="display: inline-block;  width: 49%">
                            <label style="display: inline-block;vertical-align: middle;">Time end</label>
                            <div style="width: 48%; display: inline-block;vertical-align: middle;">
                                <div class='input-group date' id='datetimepickerEnd'>
                                    <input name="endTime" id="endTime" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                    <div width="100%">
                        <div style="display: inline-block;" class="col-md-3">
                            <div class="navbar-collapse collapse sidebar-navbar-collapse">
                                <ul class="nav navbar-nav" style="width: 100%">
                                    <ul class="nav nav-pills brand-pills nav-stacked" role="tablist" style="border: 1px solid; border-radius: 6px;" id="listQuestion">
                                    </ul>

                                </ul>
                            </div>
                            <br>
                            <br>

                        </div>
                        <div style="display: inline-block; border: 1px solid; border-radius: 6px;" class="col-md-9" id="questionDetail">

                            <div id="questionDiv">

                            </div>
                            <div class="form-group" id="selectTagCreateQuestionDiv" style="display: none">
                                <label for="selectTagCreateQuestion">Tags</label>
                                <select multiple="true" style="width: 100%" id="selectTagCreateQuestion"> </select>
                            </div>
                            <div class="form-group">

                                <label style="display: none; color: #ff5f50;" id="createQuestionErrorText"></label>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" style="display: none;" id="saveOneQuestionBtn">Save question</button>
                                <button class="btn btn-danger" style="display: none;" id="removeOneQuestionBtn">Remove question</button>
                            </div>
                            <br>

                        </div>
                    </div>
                <div style="margin-left: 3%; width: 30%">
                    <button style="float:left; margin-right: 15px;" class="btn btn-primary"  id="btnAddQuestion">Add form library</button>
                    <button style="float:left; margin-right: 15px;" class="btn btn-primary"  id="btnAddQuestionNew">Add new</button>
                </div>
            </div>
            <div class="modal-footer">
                <br>
            </div>
        </div>

    </div>
</div>