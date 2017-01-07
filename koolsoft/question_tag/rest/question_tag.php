<?php
/**
 * Created by PhpStorm.
 * User: dddd
 * Date: 1/3/17
 * Time: 8:02 PM
 */
require_once("../../../config.php");
require_once("../../question_tag/models/ks_question_tag.php");

$dao = new ks_question_tag();

$action = optional_param('action', "", PARAM_TEXT);
switch ($action){
    case "create" :
        $id  = optional_param('id', 0, PARAM_INT);
        $name  = optional_param('name', 0, PARAM_TEXT);

        if($id && $id > 0){
            $tag = $dao->update($id, $name);
        }else {
            $tag = $dao->create($name);
        }

        echo json_encode($tag);
        break;

    case "listAll" :
        $tags = $dao->loadAll();
        echo json_encode($tags);
        break;

    case "one" :
        $id  = optional_param('id', 0, PARAM_INT);
        $tag = $dao->loadOne($id);
        echo json_encode($tag);
        break;

    case "delete" :
        $id  = optional_param('id', 0, PARAM_INT);
        echo $dao->delete($id);
        break;
}