<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/27/16
 * Time: 1:25 PM
 */

$fileManager = FileUtil::getFilemanager();
$data = FileUtil::listFiles($fileManager);

var_dump($fileManager);
var_dump($data);

?>

<!DOCTYPE html>
<html>
<body>

<form action="/moodle/repository/repository_ajax.php?action=upload" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="repo_upload_file">
    <input type="hidden" name="sesskey" value="<?php echo sesskey() ?>">
    <input type="hidden" name="repo_id" value="4">
    <input type="hidden" name="itemid" value="<?php echo "573059168" ?>">
    <input type="hidden" name="author" value="<?php echo $USER->firstname ?>">
    <input type="hidden" name="savepath" value="/">
    <input type="hidden" name="title" value="xxxx">
    <input type="hidden" name="ctx_id" value="5">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
