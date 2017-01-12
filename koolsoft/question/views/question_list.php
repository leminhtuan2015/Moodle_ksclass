<div class="container">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
        </tr>
        </thead>

        <tbody id="question_list_table_body">
            <?php foreach ($questions as $question) { ?>
                <tr id="question_list_table_row_<?php echo $question->id ?>">
                    <?php include ("question_row.php")?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <a href="/moodle/koolsoft/question_tag/?action=show">
        You can create new tag
    </a>
</div>
