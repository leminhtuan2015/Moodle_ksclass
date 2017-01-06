<STYLE type="text/css">
    .panelContent{
        width: 90%;
        margin: 0 auto;
    }
    .hearder-Home{
        width: 100%;
        background-color: #0091ea;
        vertical-align: middle;
        padding: 5px 0px;
    }
    .iconFont-Home{
        font-size: 2.3em;
    }
    .itemCategory-Home{
        width: calc(100% - 35px);
        color: white;
    }
</STYLE>

<div class="hearder-Home">
    <a class='iconFont-Home' href="" style="margin-left:3%;"><i class="fa fa-graduation-cap" style="color:black;width:45px;"></i></a>
    <input type="text" placeholder="Search.." style="margin-left:3%;">
    <a class='iconFont-Home' href="/moodle/koolsoft" style="margin-left:3%;"><i class="fa fa-home" style="color:black;width:45px;"></i></a>
    <div style="display:inline-block;width:30%;float:right;">
        <a class='iconFont-Home' href="" style="margin-left:3%;"><i class="fa fa-book" style="color:black;width:45px;"></i></a>
        <a class='iconFont-Home' href="" style="margin-left:3%;"><i class="fa fa-user" style="color:black;width:45px;"></i></a>
        <?php if(isloggedin()) { ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <?php global $USER;echo "$USER->username"; ?>
                <span class="caret"></span>
            </a>
        <?php } else { ?>
            <a href="/moodle/koolsoft/login">Login</a>
        <?php } ?>
        <a class='iconFont-Home' href="" style="margin-left:3%;"><i class="fa fa-bell-o" style="color:black;width:45px;"></i></a>
    </div>
</div>