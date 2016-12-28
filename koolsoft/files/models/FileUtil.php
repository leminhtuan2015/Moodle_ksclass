<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/27/16
 * Time: 10:25 PM
 */

global $CFG, $USER;

require_once($CFG->libdir.'/filelib.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/repository/lib.php');

class FileUtil {

    public static function getFilemanager(){
        global $CFG, $USER;

        $maxbytes = $CFG->userquota;
        $maxareabytes = $CFG->userquota;

        $context = context_user::instance($USER->id);
        $data = new stdClass();
        $options = array('subdirs' => 1, 'maxbytes' => $maxbytes,
            'maxfiles' => -1, 'accepted_types' => '*',
            'areamaxbytes' => $maxareabytes);

        file_prepare_standard_filemanager($data, 'files', $options, $context, 'user', 'private', 0);

        // files_filemanager = itemid in table ks_files
        return $data->files_filemanager;
    }

    public static function listFiles($itemId){
        $filepath = optional_param('filepath', '/', PARAM_PATH);
        $draftid = $itemId;

        $data = repository::prepare_listing(file_get_drafarea_files($draftid, $filepath));
        $info = file_get_draft_area_info($draftid);
        $data->filecount = $info['filecount'];
        $data->filesize = $info['filesize'];
        $data->tree = new stdClass();
        file_get_drafarea_folders($draftid, '/', $data->tree);

        return $data;
    }

    public static function upload(){

    }

    public static function sendPost($data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "/moodle/repository/draftfiles_ajax.php?action=list");
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec ($ch);
        curl_close ($ch);
        return $result;
    }

}