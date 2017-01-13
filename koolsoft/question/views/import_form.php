<input type="file" id="importQuestionButton" name="fileupload"/>

<div id='ajax_loader' style="position: fixed; left: 50%; top: 50%; display: none;">
    <img src="https://www.drupal.org/files/issues/ajax-loader.gif"></img>
</div>

<script>
    
    $("#importQuestionButton").change(function () {

        var file_data = $('#importQuestionButton').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);

        $(document).ajaxStart(function(){
            console.debug("ajaxStart");
            $("#ajax_loader").show();
        });

        $.ajax({
            url: '/moodle/koolsoft/question/rest/index.php/?action=import', // point to server-side PHP script
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(result){
//                alert(result); // display response from the PHP script, if any
                $("#importQuestionButton").val("")

                $(document).ajaxStop(function(){
                    console.debug("ajaxStop");
                    $("#ajax_loader").hide();
                });

                getByTag();

                if(!result){
                    alert("Please make sure you are submitting .xls or xlsx file");
                }
            }
        });
    });

</script>