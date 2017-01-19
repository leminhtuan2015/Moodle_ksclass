<style>
    .fileName {
        position: relative;
        width: 200px;
    }
    .fileName {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
    .fileName:after {
        content: attr(data-filetype);
        position: absolute;
        left: 100%;
        top: 0;
    }
    /*Show on hover*/
    .fileName:hover {
        width: auto
    }
    .fileName:hover:after {
        display: none;
    }
</style>

<div style="padding:10px 15px;">
    <div class="fileName" style="display:inline-block;width:calc(100% - 50px);"><a id="file_<?php echo $file->id ?>"><?php echo $file->filename ?></a></div>
    <a  style="display:inline-block;" href="/moodle/koolsoft/file/?action=download&id=<?php echo $file->id ?>" class="">
        <img src="/moodle/koolsoft/resources/images/download.png" style="width:25px;margin-right:10px;vertical-align:middle;"></img>
    </a>
    <img src="/moodle/koolsoft/resources/images/iconsetting.png" style="width:5px;display:inline-block;vertical-align:middle;"></img>
</div>

<script>
    fileId = "<?php echo $file->id ?>"

    $("#file_" + fileId).click(function () {
        filepath = "<?php echo str_replace("$CFG->dirroot", "", $file->filepath) ?>"
        filepath = "<?php echo str_replace("moodle/opt/lampp/htdocs/", "", $file->filepath) ?>"
        hostname = "<?php echo $_SERVER['HTTP_HOST']; ?>"

        url = hostname + "/moodle" + filepath

        $("#file_url_info").val("")
        $("#file_url_info").val(url)

        $('#file_info').modal('show');

    });
</script>