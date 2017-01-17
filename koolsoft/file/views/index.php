<div class="container">
    <h2>Upload</h2>
    <?php require_once ("upload_form.php")?>
    <hr>
</div>

<div class="container" id="files_container">
    <h2>Files</h2>

    <?php foreach ($files as $file) {?>
        <?php include ("file_item.php")?>
    <?php }?>
</div>