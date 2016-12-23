<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/15/16
 * Time: 10:04 PM
 */


?>

<div class="container">
        <div class="">
            <table class="table table-hover">
                <thead>
                <tr>
                    <td>Name</td>
                    <td>Last modified</td>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($courses as $course) { ?>
                    <tr style="height: 50px">
                        <td>
                            <a href='/moodle/koolsoft/course/?action=show&id=<?php echo $course->id; ?>'>
                                <?php echo $course->fullname; ?>
                            </a>
                            <br>
                            <p class='small lead'>Create by: <cite><a href="#">Owner</a></cite></p>
                        </td>
                        <td>
                            <p class='small lead'>2016/11/12</p>
                        </td>
                    </tr>

                <?php } ?>
                </tbody>
            </table>
        </div>
</div>
