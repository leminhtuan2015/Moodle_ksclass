<?php
/**
 * Created by PhpStorm.
 * User: xuan
 * Date: 29/12/2016
 * Time: 10:11
 */
class ClientUtil {
    public static  function  is_manager(){
        global $USER;
        global  $DB;
        if(is_siteadmin()){
            return true;
        }
        $sql = 'SELECT * FROM ks_role_assignments';
        $param = array();
        $array_object = $DB->get_records_sql($sql, $param);
        $array_id = array();
        $i = 0;
        foreach ($array_object as $object){
            if($object->userid == $USER->id){
                return true;
            }
        }
        return false;
    }

    public static  function  user_ismanager($id){
        global  $DB;
        $sql = 'SELECT * FROM ks_role_assignments';
        $param = array();
        $array_object = $DB->get_records_sql($sql, $param);
        $array_id = array();
        $i = 0;
        foreach ($array_object as $object){
            if($object->userid == $id){
                return true;
            }
        }
        return false;
    }


}


