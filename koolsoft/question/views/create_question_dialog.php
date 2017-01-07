<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/21/16
 * Time: 6:16 PM
 */
?>
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

<div id="createQuestionDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="createQuestionDialogHeader">Create new questions</h4>
            </div>
            <div class="modal-body">
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
                        <div class="form-group">
                            <label for="wrongAnserTxt2">Wrong Answer</label>
                            <input class="form-control" placeholder="wrong answer" id="wrongAnserTxt2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectTag">Tags</label>
                        <select multiple="true" style="width: 95%" id="selectTag"> </select>
                    </div>
                    <div class="form-group" style="display: none">
                        <button class="btn btn-link" style="float: right;" id="addWrongAnswerBtn">Add wronganswer</button>
                    </div>
                    <div class="form-group">
                        <label style="display: none; color: #ff5f50;" id="createQuestionErrorText"></label>
                    </div>
                    <br>
                    <div class="form-group" style="display: none">
                        <button class="btn btn-danger"  id="deleteQuestionBtn">Delete question</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button submit" class="btn btn-primary" id="saveQuestion">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>