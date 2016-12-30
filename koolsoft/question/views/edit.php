<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/19/16
 * Time: 10:24 PM
 */
?>
<link rel="stylesheet" type="text/css" href="resources/css/index.css">
<script src="resources/javascript/question.js"></script>

<style>
    h1 {
        margin-left: 15px;
        margin-bottom: 20px;
    }

    @media (min-width: 768px) {

        .brand-pills > li > a {
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;
        }
    }

    /* make sidebar nav vertical */
    @media (min-width: 768px) {
        .sidebar-nav .navbar .navbar-collapse {
            padding: 0;
            max-height: none;
        }
        .sidebar-nav .navbar ul {
            float: none;
            display: block;
        }
        .sidebar-nav .navbar li {
            float: none;
            display: block;
        }
        .sidebar-nav .navbar li a {
            padding-top: 12px;
            padding-bottom: 12px;
        }
    }

</style>

<div class="container">
    <div style="display: none">
        <input id="categoryId" value="<?php echo $idCategory;?>">
        <input id="returnUrl" value="<?php echo $returnUrl;?>">
    </div>
    <div>
        <h3 style="display: inline-block" id="labelCategoryName"><?php echo $category->name?> </h3>
        <input style="display: none; width: 90%;" class="form-control" id="inputCategoryName" value='<?php echo $category->name?>'>
        <a id="btnEditCategoryName">
            <span class="glyphicon glyphicon-pencil"></span>
        </a>

        <button id="btnDone" style="float: right" class="btn btn-primary">Done</button>
    </div>
    <br>
    <div width="100%">
        <div style="display: inline-block;" class="col-md-3">
            <div class="navbar-collapse collapse sidebar-navbar-collapse">
                <ul class="nav navbar-nav" style="width: 100%">
                    <ul class="nav nav-pills brand-pills nav-stacked" role="tablist" id="listQuestionTable">
                    </ul>
                </ul>
            </div>
            <br>
            <br>
            <div class="form-group">
                <button style="float: right; margin-right: 15px;" class="btn btn-primary"  id="addQuestionBtn">Add question</button>
            </div>
        </div>
        <div style="display: inline-block;" class="col-md-9">

            <div id="questionDiv">
                <div class="form-group">
                    <label for="questionTxt">Question</label>
                    <input class="form-control" placeholder="question" id="questionTxt">
                </div>
                <div class="form-group">
                    <label for="answerTxt">Answer</label>
                    <input class="form-control" placeholder="answer" id="answerTxt">
                </div>
                <div class="form-group">
                    <label for="wrongAnserTxt0">Wrong Answer</label>
                    <input class="form-control" placeholder="wrong answer" id="wrongAnserTxt0">
                </div>
                <div class="form-group">
                    <label for="wrongAnserTxt1">Wrong Answer</label>
                    <input class="form-control" placeholder="wrong answer" id="wrongAnserTxt1">
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-link" style="float: right;" id="addWrongAnswerBtn">Add wronganswer</button>

            </div>
            <div class="form-group">
                <label style="display: none; color: #ff5f50;" id="createQuestionErrorText"></label>
            </div>
            <br>
            <div class="form-group">
                <button id="saveQuestion"class="btn btn-primary">Save question</button>
                <button class="btn btn-danger"  id="deleteQuestionBtn">Delete question</button>
            </div>
        </div>
    </div>
</div>

<?php
global $CFG;
    require_once ($CFG->dirroot."/koolsoft/shared/views/alert_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/confirm_dialog.php");
?>

