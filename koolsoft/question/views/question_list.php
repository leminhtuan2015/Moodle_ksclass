<div class="container">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($questions as $question) { ?>
            <tr>
                <td><?php echo $question->id ?></td>
                <td><?php echo $question->name ?></td>
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