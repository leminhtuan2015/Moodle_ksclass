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
    <form data-toggle="validator" role="form" action="?action=edit&category=<?php echo $idCategory?>" method="post" id="formQuiz">
        <div class="form-group">
            <input id="idQuiz" id="idQuiz">
            <input id="isSave" id="isSave" value="true">
        </div>
        <div class="form-group">
            <label for="nameQuiz">Name</label>
            <input id="nameQuiz" id="nameQuiz">
        </div>
        <div class="form-group">
            <label for="descQuiz">Description</label>
            <input id="descQuiz" id="descQuiz">
        </div>
    </form>
<div class="form-group">
    <button type="submit" form="formQuiz" class="btn btn-primary">Save</button>
</div>
</div>