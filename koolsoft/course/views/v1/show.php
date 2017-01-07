<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<STYLE type="text/css">
    body{
        overflow: hidden;
    }
    .panelContent {
        width: 90%;
        margin: 0 auto;
    }

    .table-header {
        width: 50%;
        margin: 0 auto;
        overflow: hidden;
    }

    .container1 {
        width: 100px;
        background-color: #1B1B1B;
        border-right: 2px solid #797979;
        vertical-align: top;
        float: left;
        height: 100%;
    }

    .menuHome {
        text-align: center;
    }

    .text {
        color: #ADB4BB;
        line-height: 10px;
        margin-top: 13px;
        font-size: 0.9em;
    }

    .active {

    }

    .listCategory {
        vertical-align: top;
        background-color: #282828;
        height: 100%;
        padding: 5px;
    }

    .rightPanel {
        vertical-align: top;
        height: 100%;
    }

    .iconHome {
        color: #999999;
        width: 70px;
    }

    .iconPanel {
        font-size: 2.3em;
    }

    #activeContainer > ul > a.active i {
        opacity: 1;
        color: white;
    }

    #activeContainer > ul > a.active i:AFTER {
        top: 100%;
        left: 50%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        z-index: 9;
    }

    #activeContainer > ul > a > i {
        background-repeat: no-repeat;
        background-size: 100% 100%;
        padding: 10px;
        opacity: 0.3;
        color: white;
        position: relative;
    }

    .postionContent {
        position: absolute;
        height: calc(100% - 50px);
        width: 90%;
        margin: 0 auto;
    }

    .iconLogout {
        position: absolute;
        bottom: 0px;
        display: block;
        padding-left: 5px;
    }

    .white_color {
        color: white;
    }

    .btHTML {
        padding-left: 20px;
    }

    .headerRightPanel {
        padding: 10px 10px 12px 10px;
        border-bottom: 2px solid #797979;
        color: white;
        background-color: black;
        margin-top: 0px;
        width: 100%;
    }

    .iconRight {
        position: absolute;
    }

    a.disabled {
        pointer-events: none;
        cursor: default;
        color: gray;
    }

    .menuCustom {
        right: 0px;
        top: 40px !important;
        left: inherit !important;
    }

    .progressHTML {
        float: right;
    }

    .popupCreate {
        border: 1px solid gray;
        margin: 0 auto;
        vertical-align: middle;
    }
    .panelClass-show{
        width: calc(100% - 100px);
        float: right;
    }
</STYLE>

<?php require_once("new_lecture.php") ?>
<?php require_once("new_test.php") ?>
<?php require_once("new_chapter.php") ?>

<?php
    global $CFG;
    require_once ($CFG->dirroot."/koolsoft/quiz/views/create_quiz_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/quiz/views/question_category_dialog.php");
?>

<DIV class='panelContent'>
    <DIV class='postionContent'>
        <?php require_once("column1.php") ?>
        <div class="panelClass-show">
            <div class="col-xs-4 col-sm-4 col-md-4" style="padding:0px;">
                <?php require_once("column2.php") ?>
            </div>
            <div class="col-xs-8 col-sm-8 col-md-8" style="padding:0px;">
                <?php require_once("column3.php") ?>
            </div>
        </div>
    </DIV>
</DIV>
