<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/29/16
 * Time: 9:53 AM
 */
class DateUtil {
    public static $DATE_FORMAT_HTML = "YYYY/MM/DD";
    public static $DATE_FORMAT_PHP = "Y/m/d h:i A";

    public static function getTimestamp($humanDate){
        // RETURN INTEGER

        if($humanDate){
            $date = new DateTime($humanDate);
            return $date->getTimestamp();
        }

        return 0;
    }

    public static function getHumanDate($timeStamp){
        // RETURN STRING

        if($timeStamp){
            $date = date(DateUtil::$DATE_FORMAT_PHP, $timeStamp);
            return $date;
        }

        return "";
    }

    public static function todayHuman(){
        // RETURN STRING

        $today = date(DateUtil::$DATE_FORMAT_PHP);

        return $today;
    }

    public static function todayTimestamp(){
        // RETURN INTEGER

        $today = date(DateUtil::$DATE_FORMAT_PHP);

        return self::getTimestamp($today);
    }

}