<?php
/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/28/16
 * Time: 5:21 PM
 */

if($method == "free"){
    echo "Free";
    echo "<a href='/moodle/koolsoft/course/?action=selfEnrol&id=$id'>Enrol</a>";

} else {
    echo "Must pay, Coming soon";
}

?>
