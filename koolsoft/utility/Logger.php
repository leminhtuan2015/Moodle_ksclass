<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/24/16
 * Time: 9:23 AM
 */
class Logger {

    public static function log($message="log") {
        error_log(print_r($message, true));
    }

}