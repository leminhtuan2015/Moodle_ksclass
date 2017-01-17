<STYLE type="text/css">
    .panelContent{
        width: 90%;
        margin: 0 auto;
    }
    .hearder-Home{
        width: 100%;
        background-color: #1C262F;
        vertical-align: middle;
        padding: 5px 0px;
    }
    .iconFont-Home{
        font-size: 2.3em;
    }
</STYLE>

<div class="hearder-Home" style="text-align:center">
    <a class='iconFont-Home' href="" style="margin-left:3%;vertical-align: middle">
        <img src="/moodle/koolsoft/resources/images/rpund2-01.png" width="30px">
    </a>

    <a class='iconFont-Home' href="/moodle/koolsoft" style="margin-left:3%; vertical-align: middle">
        <img src="/moodle/koolsoft/resources/images/home-01.png" width="30px">
    </a>
    <a class='iconFont-Home' href="/moodle/koolsoft/question/" style="margin-left:15px;vertical-align: middle">
        <img src="/moodle/koolsoft/resources/images/library-01.png" width="30px">
    </a>

    <form style="display: inline-block;width:40%;" class="navbar-form" action="/moodle/koolsoft/search/?action=show" method="get">
        <div class="form-group" style="width:100%">
            <input type="text" style="width:100%" class="form-control" placeholder="Search" name="search">
        </div>
    </form>

    <div class="pull-right" style="display:inline-block;width:30%; vertical-align: middle;margin-top: 5px;">
        <a href="/moodle/koolsoft/course/?action=new" style="vertical-align: middle">
            <img src="/moodle/koolsoft/resources/images/create-class-01.png" width="30px">
        </a>
        <a href="" style="margin-left:15px;">
            <img src="/moodle/koolsoft/resources/images/notify-01.png" width="30px">
        </a>
        <?php if(isloggedin()) { ?>

            <div class="dropdown" style="display: inline-block">
                <a class=" dropdown-toggle" data-toggle="dropdown" style="color: black;margin-left:15px;">
                     <img src="/moodle/koolsoft/resources/images/rpund2-01.png" width="40px" style="border-radius:100%">
                    <!-- <b><?php global $USER; echo $USER->username?></b>
                    <span class="caret"></span> -->
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
        
    </div>
</div>