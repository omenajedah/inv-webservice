<?php

function &get_config($file = '') {
    include(__DIR__."/../cfg/".$file);
    return $CFG;
}

//includes all library
require_once (__DIR__.'/../lib/Router.php');
require_once("mysqldb.php");
require_once("application.php");
require_once("loader.php");
require_once("model.php");
include(__DIR__."/../cfg/config.php");
// include("core.php");

?>