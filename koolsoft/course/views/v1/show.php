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
        width: 100%;
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
        width: 100%;
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

    .btnQuiz {
        padding-left: 40px;
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

    .titleCourse {
        width: calc(100% - 40px);
    }
</STYLE>

<script src="/moodle/koolsoft/course/views/v1/resources/course.js"></script>

<?php require_once("new_lecture.php") ?>
<?php require_once("new_test.php") ?>
<?php require_once("new_chapter.php") ?>

<?php
    global $CFG;
    require_once ($CFG->dirroot."/koolsoft/quiz/views/create_quiz_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/quiz/views/question_category_dialog.php");
?>

<div class="container">
    <?php if(!$course->isEnroled){ ?>
        <?php if($course->isFree){ ?>
            <div class="alert alert-success">
                <a href="/moodle/koolsoft/course/?action=selfEnrol&id=<?php echo $course->id ?>" class="alert-link">Join this class</a>.
            </div>
        <?php } else { ?>
            <div class="alert alert-warning">
                <a href="#" class="alert-link">Pay this class</a>.
            </div>
        <?php } ?>
    <?php } ?>
</div>

<DIV class='panelContent'>
    <DIV class='postionContent'>
        <?php require_once("column1.php") ?>

        <div class="panelClass-show" id="parent_2_window">
            <div id="div1">
                <?php require_once("column2.php") ?>
            </div>
            <div id="div2">
                <?php require_once("column3.php") ?>
            </div>
        </div>
    </DIV>
</DIV>

<style>
    #parent_2_window{
        /*position:absolute;*/
        /*height:100%;*/
        /*margin:0;*/
        /*padding:0;*/
        /*width:100%;*/
    }
    #div1{
        position:relative;
        float:left;
        height:100%;
        width:20%;
        background-color:#A2A;
    }
    #div2{
        position:relative;
        float:right;
        height:100%;
        width:80%;
        background-color:#BBB;
    }
</style>

<script >
    $("#div1").resizable();
    $('#div1').resize(function(){
        $('#div2').width($("#parent_2_window").width()-$("#div1").width());
    });
    $(window).resize(function(){
        $('#div2').width($("#parent_2_window").width()-$("#div1").width());
        $('#div1').height($("#parent_2_window").height());
    });

    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });

</script>