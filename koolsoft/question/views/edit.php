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

<div class="container">
    <form data-toggle="validator" role="form" action="?action=edit&category=<?php echo $idCategory?>" method="post" id="formQuestion">
        <?php echo "<input style='display: none' name='category' value='".$idCategory."'>"; ?>
        <?php echo "<input style='display: none' name='returnUrl' value='".$returnUrl."'>"; ?>
        <?php echo "<input style='display: none' name='save' value='true'>"; ?>
        <?php echo "<input style='display: none' name='numberQuestion' id='numberQuestion' value='".$numberQuestion."'>"; ?>
        <?php
            echo $questionHtml;
        ?>
    </form>
    <div class="form-group">
        <button id="addQuestion">Add question</button>
    </div>
    <div class="form-group">
        <button type="submit" form="formQuestion" class="btn btn-primary">Save</button>
    </div>
</div>

