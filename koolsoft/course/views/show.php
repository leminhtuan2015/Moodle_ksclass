<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:04 PM
 */

require_once(__DIR__."/../../shared/views/confirm.php");


if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
if(isset($_POST['typeadd'])){
    $typeAdd = $_POST['typeadd'];
    if($typeAdd == "Label") {
        header("Location: /moodle/koolsoft/course/");
//          header("Location: http://localhost/moodle/koolsoft/course/");
    }
}

?>
<link rel="stylesheet" href="../../resources/css/adddata.css">

<div class="container">
    <h2>Course: <?php echo $course->fullname ?></h2>
    <div class="btn-group pull-right" role="group">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="/moodle/koolsoft/course/?action=edit&id=<?php echo $course->id ?>">Edit</a></li>
                <li>
                    <a data-toggle="modal" data-target="#confirm-delete"
                       data-href="/moodle/koolsoft/course/?action=delete&id=<?php echo $course->id ?>">Delete</a>
                </li>
            </ul>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Lectures</a></li>
        <li><a data-toggle="tab" href="#menu1">Document</a></li>
        <li><a data-toggle="tab" href="#menu2">Posts</a></li>
        <li><a data-toggle="tab" href="#members">Members</a></li>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <br>

            <div class="list-group ">
                <?php foreach ($sections as $section) { ?>

                    <?php
                        if($section->section == 0){
                            continue;
                        }
                    ?>

                    <?php echo "<a class='list-group-item' 
                        href='/moodle/koolsoft/lecture/?action=show&id=$section->id&courseId=$course->id'>$section->name</a>" ?>
                <?php } ?>
            </div>

        </div>
        <div id="menu1" class="tab-pane fade">
            <h3>Document</h3>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div id="menu2" class="tab-pane fade">
            <br>
            <?php include (__DIR__."/../../shared/views/create_message_box.php"); ?>
        </div>
        <div id="members" class="tab-pane fade">
            <h3>Members</h3>
            <ul class="list-group">
                <?php foreach ($enrolledUsers as $enrolledUser) { ?>

                    <li class="list-group-item">
                        <a href="../../user/profile.php?id=<?php echo $enrolledUser->id ?>"> <?php echo "$enrolledUser->username ($enrolledUser->email)" ?></a>
                    </li>
                <?php } ?>
            </ul>

        </div>
    </div>
</div>

<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Add an activity or resource</h2>
            </div>
            <form action="/moodle/koolsoft/course/?action=show&id=<?php echo $id ?>" method="post" id="mainForm" name="mainForm">
                <div  class="modal-body">
                        <div class="radio">
                            <label><input type="radio" name="optradio" class="radioButton" value="assigment">Assigment</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio" class="radioButton" value="chat">Chat</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio" value="choise">Choise</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio" value="extenaltool">External tool</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio" value="label">Label</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio" value="folder">Folder</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio" value="file">File</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio" value="url">Url</label>
                        </div>
                        <input type="hidden" id="typeadd" name="typeadd" value="typeadd">
                    <p id="radioContent"></p>

                </div>

                <div class="modal-footer">
                    <button id="btnAdd" type="button" name="submit" class="btn btn-primary">Add</button>
                    <button id="btnCancel" type="button" class="btn btn-default">Cancel</button>
                </div>
        </form>
    </div>

</div>

<script>
    // Get the modal
    var modal = document.getElementById('myModal');
    var btn = document.getElementById("addResource");
    var btnCancel = document.getElementById("btnCancel");
    var btnSubmit = document.getElementById("btnAdd");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    var sectionId ;
    function functionAddResource(section){
        modal.style.display = "block";
        sectionId = section;
    }


    btnCancel.onclick = function() {
        hideDialog();
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    var selectedValue;
    $('#mainForm input').on('change', function() {
        selectedValue = $('input[name=optradio]:checked', '#mainForm').val();
        document.getElementById("typeadd").value = selectedValue;
        switch(selectedValue){
            case "assigment":
                document.getElementById("radioContent").innerHTML = "Choose assigment not supports";
                break;
            case "chat":
                document.getElementById("radioContent").innerHTML = "Choose chat not support";
                break;
            case "choise":
                document.getElementById("radioContent").innerHTML = "Choose choise not support";
                break;
            case "extenaltool":
                document.getElementById("radioContent").innerHTML = "Choose extenaltool not support";
                break;
            case "label":
                document.getElementById("radioContent").innerHTML = "Choose label ok nhe";
                break;
            case "folder":
                document.getElementById("radioContent").innerHTML = "Choose folder not support";
                break;
            case "file":
                document.getElementById("radioContent").innerHTML = "Choose file not support";
                break;
            case "url":
                document.getElementById("radioContent").innerHTML = "Choose url not support";
                break;

        }
        if(selectedValue == "label"){

        }
    });

    function hideDialog() {
        modal.style.display = "none";
    }
    btnSubmit.onclick = function() {
        hideDialog();
        if(selectedValue != null && selectedValue == "label"){
            var id = "<?php echo $id?>";
            var courseId = "<?php echo $course->id?>"
            location.href = "/moodle/koolsoft/course/?action=adddata&add=" + selectedValue + "&idcourse=" + courseId+"&lecture=" + sectionId + "&id=" + id;
        }
    }


</script>