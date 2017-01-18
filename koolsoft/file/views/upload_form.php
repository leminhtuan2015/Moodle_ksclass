<form id="uploadFileForm">
    
    <input type="file" name="file" id="fileOfCourseInput" style="display:inline-block; width:calc(100% - 100px);">
    <input type="hidden" value="<?php echo $coure_id ?>" name="course_id">
    <input type="submit" value="Upload" name="submit"
           style="display:inline-block; border: none; padding: 7px 25px; color: white; background-color: #3584D4;">

</form>

<script>

    $("#uploadFileForm").on("submit", function (event) {
        event.preventDefault()

        coure_id = "<?php echo $coure_id ?>"

        var fileInput = document.getElementById("fileOfCourseInput")
        var file = fileInput.files[0]
        var formData = new FormData()

        if(!file){
            alert("Please choose file first")
            return
        }

        formData.append("file", file);
        formData.append("course_id", coure_id);

        var client = new XMLHttpRequest()
        client.open("post", "/moodle/koolsoft/file/?action=upload", true);
        client.send(formData);

        /* Check the response status */
        client.onload = function() {
            if (client.readyState === client.DONE && client.status == 200) {
                $("#fileOfCourseInput").val("")
//                alert(client.statusText);
//                alert(client.response);
//                alert(client.responseText);

                $("#files_container").prepend(client.responseText)
            } else {
                alert("Please try again, sothings went wrong")
            }
        }


    })

</script>

