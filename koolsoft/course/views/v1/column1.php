<div class="container1" id="activeContainer">
    <ul class="nav nav-pills menuHome">
        <li class="active"><a class='iconPanel iconActiveHome' data-toggle="pill" href="#Home"><i class=" fa fa-home iconHome"></i></a></li>
         <li>
             <a class='iconPanel iconActiveHome' data-toggle="pill" href="#course_file" id="course_file_menu">
                 <img src="../resources/images/document-01.png" class="iconHome">
             </a>
         </li>
          <li>
              <a class='iconPanel iconActiveHome' data-toggle="pill" href="#discussionBox"
                 id="course_discussion_btn_column1">
                  <img src="../resources/images/disscusion-01.png" class="iconHome">
              </a>
          </li>
         <li>
             <a class='iconPanel iconActiveHome' data-toggle="pill" href="#members">
                 <img src="../resources/images/member-2-01.png" class="iconHome">
             </a>
         </li>
    </ul>
</div>

<script>
    $("#course_file_menu").click(function () {
        course_id = "<?php echo $course->id ?>"

        $.ajax({
            type: "get",
            url: "/moodle/koolsoft/file/index.php?action=filesOfCourse",
            data : {"course_id": course_id},
            success: function(result){
                if(result){
                    $("#course_file").html(result)
                } else {
                    alert("Somethings wrong. Please try again.")
                }
            }
        });
    })

</script>