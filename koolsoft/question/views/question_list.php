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
                <td><a href="#"><?php echo $question->name ?></a></td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle"
                                type="button" data-toggle="dropdown">Edit
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-toggle="modal"
                                   data-target="#editQuestionDialog<?php echo $question->id ?>">Edit</a> </li>
                            <li><a href="#">Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>

            <?php include ("edit_question_dialog.php")?>

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
