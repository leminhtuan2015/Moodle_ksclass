<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/17/16
 * Time: 2:25 PM
 */

function tree(&$rootCategory) {
    $size = count($rootCategory->childrent);

    if($size > 0){
        echo "<ul>";
        foreach ($rootCategory->childrent as $c) {
            echo "<li><a href='/moodle/koolsoft/category/?action=show&id=$c->id'>$c->name</a>";
            tree($c);
            echo "</li>";
        }
        echo "</ul>";
    }
}

function tree1(&$rootCategory) {
    $size = count($rootCategory->childrent);

    if($size > 0){
        echo "<ul class=\"list-group\">";

        foreach ($rootCategory->childrent as $c) {
            echo "<li class=\"list-group-item\"><span class=\"glyphicon glyphicon-pencil text-primary\"></span><a href=>$c->name</a>";
            tree1($c);
            echo "</li>";
        }
        echo "</ul>";
    }
}

?>

<div class="container">
    <a type="button" class="btn btn-success pull-right" href="/moodle/koolsoft/category/?action=edit">Create category</a>
</div>

<style>
#accordion .glyphicon { margin-right:5px; }
.panel-collapse>.list-group .list-group-item:first-child {border-top-right-radius: 0;border-top-left-radius: 0;}
.panel-collapse>.list-group .list-group-item {border-width: 1px 0;}
.panel-collapse>.list-group {margin-bottom: 0;}
.panel-collapse .list-group-item {border-radius:0;}

.panel-collapse .list-group .list-group {margin: 0;margin-top: 10px;}
.panel-collapse .list-group-item li.list-group-item {margin: 0 -15px;border-top: 1px solid #ddd !important;border-bottom: 0;padding-left: 30px;}
.panel-collapse .list-group-item li.list-group-item:last-child {padding-bottom: 0;}

.panel-collapse div.list-group div.list-group{margin: 0;}
.panel-collapse div.list-group .list-group a.list-group-item {border-top: 1px solid #ddd !important;border-bottom: 0;padding-left: 30px;}
.panel-collapse .list-group-item li.list-group-item {border-top: 1px solid #DDD !important;}

</style>

<div class="container" style="margin-top: 20px">
    <div class="row">
        <div class="col-sm-3 col-md-3">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                <span class="glyphicon glyphicon-folder-close"></span>Content
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
<!--                        <ul class="list-group">-->
<!--                            <li class="list-group-item"><span class="glyphicon glyphicon-pencil text-primary"></span><a href="http://fb.com/moinakbarali">Articles</a>-->
<!--                                <ul class="list-group">-->
<!--                                    <li class="list-group-item"><span class="glyphicon glyphicon-pencil text-primary"></span><a href="http://fb.com/moinakbarali">Article 0</a></li>-->
<!--                                    <li class="list-group-item"><span class="glyphicon glyphicon-pencil text-primary"></span><a href="http://fb.com/moinakbarali">Article 1</a>-->
<!--                                        <ul class="list-group">-->
<!--                                            <li class="list-group-item"><span class="glyphicon glyphicon-pencil text-primary"></span><a href="http://fb.com/moinakbarali">Article 2</a>-->
<!---->
<!--                                            </li>-->
<!--                                        </ul>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!---->
<!--                            <li class="list-group-item"><span class="glyphicon glyphicon-flash text-success"></span><a href="http://fb.com/moinakbarali">News</a></li>-->
<!--                        </ul>-->
                        <!-- SHOW LIST-->

                        <?php tree($rootCategory); ?>

                        <?php //tree1($rootCategory); ?>

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="glyphicon glyphicon-file">
                    </span>Reports</a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="list-group">
                            <a href="#" class="list-group-item">
                                Cras justo odio
                            </a>
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    Cras justo odio
                                </a>
                                <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
                                <a href="#" class="list-group-item">Morbi leo risus</a>
                                <a href="#" class="list-group-item">Porta ac consectetur ac</a>
                                <a href="#" class="list-group-item">Vestibulum at eros</a>
                            </div>
                            <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
                            <a href="#" class="list-group-item">Morbi leo risus</a>
                            <a href="#" class="list-group-item">Porta ac consectetur ac</a>
                            <a href="#" class="list-group-item">Vestibulum at eros</a>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><span class="glyphicon glyphicon-heart">
                    </span>Reports</a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse">
                        <div class="list-group">
                            <a href="#" class="list-group-item">
                                <h4 class="list-group-item-heading">List group item heading</h4>
                                <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                            </a>
                        </div>
                        <div class="list-group">
                            <a href="#" class="list-group-item active">
                                <h4 class="list-group-item-heading">List group item heading</h4>
                                <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                            </a>
                        </div>
                        <div class="list-group">
                            <a href="#" class="list-group-item">
                                <h4 class="list-group-item-heading">List group item heading</h4>
                                <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-9 col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Courses</h3>
                </div>
                <div class="panel-body">
                    <div class="alert">
                        <?php
                        foreach ($coursesOfCategory as $course) {
                            echo "<h3><a href='/moodle/koolsoft/course/?action=show&id=$course->id'>$course->fullname</a></h3>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





