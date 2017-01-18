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

<div>
    <div class="fileName"><?php echo $file->filename ?></div>
    <a  href="/moodle/koolsoft/file/?action=download&id=<?php echo $file->id ?>"
        class="">Download</a>
</div>
<hr>