<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:27 PM
 */

?>

<style>
    h1 {
        margin-left: 15px;
        margin-bottom: 20px;
    }

    @media (min-width: 768px) {

        .brand-pills > li > a {
            border-top-right-radius: 0px;
            border-bottom-right-radius: 0px;
        }
    }

    /* make sidebar nav vertical */
    @media (min-width: 768px) {
        .sidebar-nav .navbar .navbar-collapse {
            padding: 0;
            max-height: none;
        }
        .sidebar-nav .navbar ul {
            float: none;
            display: block;
        }
        .sidebar-nav .navbar li {
            float: none;
            display: block;
        }
        .sidebar-nav .navbar li a {
            padding-top: 12px;
            padding-bottom: 12px;
        }
    }

</style>

<div class="container">
    <div class="row">
        <div role="tabpanel">
            <div class="col-xs-3">
                <div class="sidebar-nav">
                    <div class="navbar navbar-default" role="navigation">
                        <div class="navbar-collapse collapse sidebar-navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="#">My Courses</a></li>

                                <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">
                                    <?php foreach ($courses as $course){ ?>
                                        <li role="presentation" class="brand-nav">
                                            <a href="#<?php echo $course->id ?>" aria-controls="tab4" role="tab" data-toggle="tab"><?php echo $course->fullname ?></a>
                                        </li>
                                    <?php } ?>

                                    <li role="presentation" class="brand-nav">
                                        <a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab">More...</a>
                                    </li>

                                </ul>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </div>

            <div class="col-sm-9">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active">
                        <p> Add Question <br>

                        </p>
                    </div>

                    <?php foreach ($courses as $course){ ?>
                        <div role="tabpanel" class="tab-pane" id="<?php echo $course->id ?>">
                            <?php include (__DIR__."/course_detail.php"); ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>



<!--//k kkk k kk k k-->



