<html>
<head>
    <link rel="stylesheet" href="../../../resources/css/adddata.css">
</head>
</html>


<?php

require_once(__DIR__."/../../../shared/header.php");
require_once(__DIR__."/../../../course/models/Label.php");

if(isset($_GET['idcourse'])) {
    $course_id = $_GET['idcourse'];
}
if(isset($_GET['lecture'])) {
    $lecture_id = $_GET['lecture'];
}

if($_SERVER['REQUEST_METHOD'] == "POST") {
    if(!empty($_POST["label"])) {
        $content = $_POST['label'];
        $courseid = $_POST['courseid'];
        $section = $_POST['section'];
        $label = new Label();
//        $label->addData($courseid,$section,$content);
        $label->addData($courseid,$section,$content);
        header('Location: ' . "/moodle/koolsoft/course");
    }
}
?>

<div id="divForm">
    <form action="addlabel.php" method="POST">
        <div class="form-group">
            <label for="email">Label Add</label>
            <input type="text" class="form-control" name="label">
            <input type="hidden" class="form-control" name="courseid" value="<?php echo $course_id;?>" >
            <input type="hidden" class="form-control" name="section" value="<?php echo $lecture_id;?>">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>



