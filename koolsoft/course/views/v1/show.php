<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<STYLE type="text/css">

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
        width: 25%;
        vertical-align: top;
        background-color: #282828;
        float: left;
        height: 100%;
        padding: 5px;
    }

    .rightPanel {
        width: 65%;
        display: inline-block;
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
        height: 100%;
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
        top: 0px;
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
</STYLE>

<?php require_once("new_lecture.php") ?>
<?php require_once("new_test.php") ?>
<?php require_once("new_chapter.php") ?>

<DIV class='panelContent'>
    <DIV class='postionContent'>
        <?php require_once("column1.php") ?>
        <?php require_once("column2.php") ?>
        <?php require_once("column3.php")?>
    </DIV>
</DIV>
