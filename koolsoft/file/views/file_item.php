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
    <div class="fileName" style="display:inline-block;width:calc(100% - 50px);"><?php echo $file->filename ?></div>
    <a  style="display:inline-block;" href="/moodle/koolsoft/file/?action=download&id=<?php echo $file->id ?>" class="">
        <img src="/moodle/koolsoft/resources/images/download.png" style="width:25px;margin-right:10px;vertical-align:middle;"></img>
    </a>
    <img src="/moodle/koolsoft/resources/images/iconsetting.png" style="width:5px;display:inline-block;vertical-align:middle;"></img>
</div>
