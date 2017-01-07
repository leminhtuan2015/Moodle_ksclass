<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/22/16
 * Time: 8:39 AM
 */
?>
<script src="resources/javascript/quiz.js"></script>

<div class="container">
    <?php
//        if($currentQuiz){
//            echo "<h2><a href='/moodle/koolsoft/course/?action=show&id=".$course->id."'>Class: ".$course->fullname."</a>/"
//                ."<a href='/moodle/koolsoft/lecture/?action=show&courseId=".$course->id."&id=".$currentSection->id."'>".$currentSection->name."</a>/"
//                ." <span class='text-primary'>".$currentQuiz->name."</span></h2>";
//        }else {
//            echo "<h2><a href='/moodle/koolsoft/course/?action=show&id=".$course->id."'>Class: ".$course->fullname."</a>/"
//                ."<a href='/moodle/koolsoft/lecture/?action=show&courseId=".$course->id."&id=".$currentSection->id."'>".$currentSection->name."</a>/"
//                ." <span class='text-primary'>Create new quiz</span></h2>";
//        }
    ?>
    <form data-toggle="validator" role="form" action="?action=edit&course=<?php echo $courseid?>&section=<?php echo $section?>" method="post" id="formQuiz">
        <div style="display: none" class="form-group">
            <input id="idQuiz" name="idQuiz" value="<?php echo $id?>">
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
        <div class="form-group" >
            <label for="sel1">Chapter:</label>
            <select class="form-control" id="sel1">

            </select>

            <label for="sel1">Lecture:</label>
            <select class="form-control" id="sel1">

            </select>
        </div>
        <div class="form-group" >
            <label>Time start</label>
            <div style="width: 49%">
                <div class='input-group date' id='datetimepickerStart'>
                    <input id="startTimeText" type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <input style="display: none" name="startTime" id="startTime"/>
            </div>
            <label>Time end</label>
            <div style="width: 49%">
                <div class='input-group date' id='datetimepickerEnd'>
                    <input id="endTimeText" type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <input style="display: none" name="endTime" id="endTime"/>
            </div>

        </div>
    </form>
<!--    <table class='table'>-->
<!--        <thead>-->
<!--        <tr>-->
<!--            <th class="col-md-2"><input type='checkbox' value='' id='idCheckBoxQuestionAll'></th>-->
<!--            <th class="col-md-2">STT</th>-->
<!--            <th class="col-md-8">Question</th>-->
<!--        </tr>-->
<!--        </thead>-->
<!--        <tbody id="bodyTableQuestion">-->
<!---->
<!--        </tbody>-->
<!--    </table>-->
<!--    <div class="form-group">-->
<!--        <button class="btn" id="btnAddQuestion">Add question</button>-->
<!--        <button class="btn" id="btnDeleteQuestion">Delete question</button>-->
<!--    </div>-->

    <div width="100%">
        <div style="display: inline-block;" class="col-md-3">
            <div class="navbar-collapse collapse sidebar-navbar-collapse">
                <ul class="nav navbar-nav" style="width: 100%">
                    <ul class="nav nav-pills brand-pills nav-stacked" role="tablist" style="border: 1px solid;height: 400px; border-radius: 6px;" id="listQuestion">
                    </ul>
                </ul>
            </div>
            <br>
            <br>
            <div class="form-group">
                <button style="float: right; margin-right: 15px;" class="btn btn-primary"  id="btnAddQuestion">Add form library</button>
                <button style="float: right; margin-right: 15px;" class="btn btn-primary"  id="btnAddQuestionNew">Add new</button>
            </div>
        </div>
        <div style="display: inline-block; border: 1px solid;height: 400px; border-radius: 6px;" class="col-md-9" id="questionDetail">

            <div id="questionDiv">

            </div>
<!--            <div class="form-group">-->
<!--                <button class="btn btn-link" style="float: right;" id="addWrongAnswerBtn">Add wronganswer</button>-->
<!---->
<!--            </div>-->
            <div class="form-group">
                <label style="display: none; color: #ff5f50;" id="createQuestionErrorText"></label>
            </div>
            <br>
<!--            <div class="form-group">-->
<!--                <button id="saveQuestion"class="btn btn-primary">Save question</button>-->
<!--                <button class="btn btn-danger"  id="deleteQuestionBtn">Delete question</button>-->
<!--            </div>-->
        </div>
    </div>
    <button type="submit" id="saveQuiz" form="formQuiz" class="btn btn-primary" style="float: right;"> Save quiz</button>
</div>

<?php
    global $CFG;
    require_once ("question_category_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/alert_dialog.php");
?>