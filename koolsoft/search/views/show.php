<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/20/16
 * Time: 11:31 AM
 */

if(!$courses){
    echo "<div class='container'><h3>No Course Found</h3></div>";
    return;
}

require_once(__DIR__."/../../course/views/index.php");

?>