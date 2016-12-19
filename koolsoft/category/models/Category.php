<?php

/**
 * Created by PhpStorm.
 * User: leminhtuan
 * Date: 12/19/16
 * Time: 10:27 AM
 */
class Category {
    public $id = 0;
    public $name = "root";
    public $childrent = array();

    function __construct() {
        $this->id = 0;
        $this->name = "root";
        $this->childrent = array();
    }
}