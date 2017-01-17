<STYLE type="text/css">
    .itemCategory-Home{
        width: calc(100% - 45px);
        color: white;
    }
    .textOverflow{
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .panelItemHome:hover{
        box-shadow: 0px 0px 2px 2px gray;
    }
    a:-webkit-any-link {
        color: -webkit-link;
        text-decoration: none !important;
        cursor: auto;
    }
</STYLE>

<div class="col-xs-6 col-sm-6 col-md-3 " style="margin:10px 0px;">
    <a href="/moodle/koolsoft/course/?action=show&id=<?php echo $course->id ?>">
        <div style="border:1px solid black;border-radius:5px;cursor: pointer;" class="panelItemHome">
            <div style="background-color:#EEEEEE;padding:5px;border-top-right-radius:5px;border-top-left-radius:5px;">
                <h5 style="display:inline-block;color:black;margin-left:10px;vertical-align: middle;" class="itemCategory-Home textOverflow"><?php echo $course->fullname ?></h5>
                <i class="fa fa-star-o" style="color:#F8B40B;width:30px;vertical-align: middle;font-size: 2.0em; transform: rotate(45deg);
                    -moz-transform: rotate(45deg);
                    -webkit-transform: rotate(45deg);
                    -o-transform: rotate(45deg);
                    -ms-transform: rotate(45deg);">
                </i>
            </div>
            <h5 style="color:#8BC77B;padding:0px 10px;"><?php echo $course->cost ?>free</h5>
            <div style="padding:0px 10px;vertical-align:middle;">
                <h5 style="display:inline-block;color:black;">6969</h5>
                <img src="/moodle/koolsoft/resources/images/member-01.png" style="padding-left:10px;width:45px;">
                <div style=" width: calc(100% - 130px);float:right;text-align:center;">
                    <div style="height:8px;background-color:#DCDCDC;">
                        <div style="height:8px;background-color:#F8B40B;width:70%;"></div>
                    </div>
                    <h6 style="color:black;margin:2px;">7/10</h6>
                </div>
            </div>
            <h5 style="color:black;padding:0px 10px;" class="textOverflow">Create by: <?php echo $course->creator->firstname ?></h5>
        </div>
    </a>
</div>