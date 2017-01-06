<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/3/17
 * Time: 8:22 PM
 */
?>
<script src="/moodle/koolsoft/question_tag/resources/javascript/question_tag.js"></script>
<div class="container">
    <a href="#" id="showAddTagDialog" class="btn btn-info btn-lg">
        <span class="glyphicon glyphicon-plus-sign"></span> Add tag
    </a>
    <table class="table table-hover">
        <thead>
        <tr>
            <td>No</td>
            <td>Tag name</td>
            <td>Action</td>
        </tr>
        </thead>
        <tbody id="idBodyTableTag">

        </tbody>
    </table>
</div>
<?php
    global $CFG;
    require_once ("create_tag_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/alert_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/confirm_dialog.php");
?>