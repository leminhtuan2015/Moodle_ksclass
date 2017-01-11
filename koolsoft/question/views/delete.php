<script>

    $("#delete_<?php echo $question->id ?>").click(function () {
        var data = {};

        data.id = "<?php echo $question->id ?>"
        data.qtype = "multichoice";
        data.action = "delete";

        $.ajax({
            url: "/moodle/koolsoft/question/rest/index.php",
            data : data,
            success: function(result){
                if(result){
                    getByTag()
                }else {
                    $("#alertContent").html("Can not delete question!");
                }
            }});
    });

</script>