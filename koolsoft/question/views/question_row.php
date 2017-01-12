<td><?php echo $question->id ?></td>
<td><a href="#" id="showDetailQuestion<?php echo $question->id ?>">
        <?php if($question->question){echo $question->question;} else {echo $question->name;} ?>
    </a>
</td>
<td>
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Edit
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" class="editQuestion"  id="openQuestionDialog<?php echo $question->id ?>">Edit</a> </li>
            <li><a href="#" class="deleteQuestion" id="delete_question<?php echo $question->id ?>">Delete</a></li>
        </ul>
    </div>
</td>

<script>
    $("#openQuestionDialog<?php echo $question->id ?>").click(function () {
        $.ajax({
            type: 'get',
            url: '/moodle/koolsoft/question/rest/index.php/?action=edit&id=<?php echo $question->id ?>',
            data: {},
            success: function (result) {
//                alert(result)

                $("#modal_container").empty()
                $("#modal_container").html(result)

                $('#editQuestionDialog<?php echo $question->id ?>').modal('show');
            }
        });
    });

    $("#showDetailQuestion<?php echo $question->id ?>").click(function () {
        $.ajax({
            type: 'get',
            url: '/moodle/koolsoft/question/rest/index.php/?action=show&id=<?php echo $question->id ?>',
            data: {},
            success: function (result) {

                $("#modal_container").empty()
                $("#modal_container").html(result)

                $('#showDetailQuestionDialog').modal('show');
            }
        });
    });

    $("#delete_question<?php echo $question->id ?>").click(function () {
        var data = {};

        data.id = "<?php echo $question->id ?>"
        data.qtype = "multichoice";
        data.action = "delete";

        $.ajax({
            url: "/moodle/koolsoft/question/rest/index.php",
            data : data,
            success: function(result){
                if(result){
                    $("#question_list_table_row_<?php echo $question->id ?>").html("")

                }else {
                    $("#alertContent").html("Can not delete question!");
                }
            }});
    });

</script>