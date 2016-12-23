<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/22/16
 * Time: 1:51 PM
 */

require_once(__DIR__."/../../shared/views/confirm.php");

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
                                <li class="active"><a href="#">Lectures</a></li>

                                <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">
                                    <?php foreach ($sections as $section){ ?>
                                        <?php if($id == $section->id ){ ?>
                                            <li class="active" role="presentation" class="brand-nav">
                                        <?php } else { ?>
                                            <li role="presentation" class="brand-nav">
                                        <?php } ?>

                                            <a href="#<?php echo $section->id ?>" aria-controls="tab4"
                                               role="tab" data-toggle="tab"><?php echo $section->name ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </div>
            </div>

            <div class="col-sm-9">
                <div class="tab-content">
                    <?php foreach ($sections as $section){ ?>
                        <?php if($id == $section->id){ ?>
                            <div role="tabpanel" class="tab-pane active" id="<?php echo $section->id ?>">
                        <?php } else { ?>
                                <div role="tabpanel" class="tab-pane" id="<?php echo $section->id ?>">
                        <?php } ?>
                            <?php include (__DIR__."/lecture_detail.php"); ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>





