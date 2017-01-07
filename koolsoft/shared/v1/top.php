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

    <form style="display: inline-block; " class="navbar-form" action="/moodle/koolsoft/search/?action=show" method="get">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search" name="search">
        </div>
    </form>

    <a class='iconFont-Home' href="/moodle/koolsoft" style="margin-left:3%; vertical-align: middle">
        <i class="fa fa-home" style="color:black;width:45px;"></i>
    </a>

    <div class="pull-right" style="display:inline-block;width:30%; vertical-align: middle; margin-top: 10px;">
        <a class='iconFont-Home' href="/moodle/koolsoft/question/?action=edit" style="margin-left:3%;"><i class="fa fa-book" style="color:black;width:45px;"></i></a>
        <a class='iconFont-Home' href="" style="margin-left:3%;"><i class="fa fa-user" style="color:black;width:45px;"></i></a>
        <?php if(isloggedin()) { ?>

            <div class="dropdown" style="display: inline-block">
                <a class=" dropdown-toggle" data-toggle="dropdown" style="color: black">
                    <b><?php global $USER; echo $USER->username?></b>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">Profile</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="/moodle/koolsoft/login/logout.php">Logout</a></li>
                </ul>
            </div>

        <?php } else { ?>
            <b><a href="/moodle/koolsoft/login" style="color: black">Login</a></b>
        <?php } ?>
        <a class='iconFont-Home' href="" style="margin-left:3%;"><i class="fa fa-bell-o" style="color:black;width:45px;"></i></a>
    </div>
</div>