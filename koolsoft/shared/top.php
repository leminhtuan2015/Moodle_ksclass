<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/moodle/koolsoft/">KS-CLASS</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/moodle/koolsoft/library/">Library</a></li>
                <li>
                    <a href="/moodle/koolsoft/course/?action=new">
                        <span class="glyphicon glyphicon-plus "></span> Class
                    </a>
                </li>
            </ul>
            <form class="navbar-form navbar-left" action="/moodle/koolsoft/search/?action=show" method="get">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search" name="search">
                </div>
            </form>

            <ul class="nav navbar-nav navbar-right">
                <?php if(isloggedin()) { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php
                            global $USER;
                            echo "$USER->username";
                            ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Profile</a></li>
                            <li><a href="/moodle/koolsoft/course/?action=myCourses">My classes</a></li>
                            <li><a href="#">Setting</a></li>
                            <li><a href="/moodle/koolsoft/category">Category</a></li>
                            <li><a href="/moodle/koolsoft/course">Classes</a></li>
                            <li><a href="/moodle/koolsoft/course/?action=new">Create Classes</a></li>
                            <li><a href="/moodle/koolsoft/home">Home <span class="sr-only">(current)</span></a></li>
                            <?php
                            if(is_siteadmin()){
                                echo "<li><a href=\"/moodle/koolsoft/admin/user/?action=listuser\">Manager User</a></li>";
                            }
                            ?>
                            <li role="separator" class="divider"></li>
                            <li><a href="/moodle/koolsoft/login/logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php } else { ?>
                    <!--                  <li><a href="/moodle/login/index.php">Login</a></li>-->
                    <li><a href="/moodle/koolsoft/login">Login</a></li>
                <?php } ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>