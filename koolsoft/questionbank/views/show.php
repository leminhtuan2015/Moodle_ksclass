<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 12/21/16
 * Time: 12:53 PM
 */
?>
<script src="/moodle/koolsoft/questionbank/resources/javascript/questionbank.js"></script>
<div class="container">
    <h4>Question bank<span class='label label-default'></span></h4>
    <input id="numberQuestion" style="display: none" value="<?php echo count($questions) ?>">
    <input id="category" style="display: none" value="<?php echo "".$categoryid; ?>">
    <input id='courseid' style='display: none' value='<?php echo $courseid; ?>'>
    <input id='urlEdit' style='display: none' value='<?php echo $urlEdit; ?>'>
    <label for='category'>Select catefory question:</label>
    <?php echo \html_writer::select($catmenu, 'category', null, array(), array('class' => 'searchoptions custom-select', 'id' => 'id_selectacategory')); ?>
    <button class='btn-xs' id='editBtn'>Edit question category</button>
    <table class='table'>
        <thead>
            <tr>
            <th class="col-md-1"><input type='checkbox' value='' id='idCheckBoxAll'></th>
            <th class="col-md-7">Question</th>
            <th class="col-md-2">Create time</th>
            <th class="col-md-2">Last modified</th>
          </tr>
        </thead>
        <tbody id="bodyTableQuestionBank">
    <!--    --><?php
    //    $i = 0;
    //    foreach ($questions as $question){
    //        echo "<tr>
    //                <td><input type='checkbox' value='' id='idCheckBox".$i."' idQuestion='".$question->id."' nameQuestion='".$question->name."'></td>
    //                <td>".$question->name."</td>
    //                <td>".date("d/m/Y", $question->timecreated)."</td>
    //                <td>".date("d/m/Y", $question->timemodified)."</td>
    //              </tr>";
    //        $i ++;
    //    }
    //    ?>
    </tbody>
    </table>
    <button class='btn' id="showViewDeleteQuestionBtn">Delete</button>
</div>
<?php
    global $CFG;
    require_once ("delete_dialog.php");
    require_once ($CFG->dirroot."/koolsoft/shared/views/alert_dialog.php");
?>
