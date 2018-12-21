<?php

$dir = explode('\\', __DIR__);
$root_dir = $dir[count($dir)-2];

define('ROOT_PATH', '/'.$root_dir);
define("MODULE_NAME", "m");
define("METHOD_NAME", "f");
define("DEFAULT_CONTROLLER", "com/firman/controller/mobile");
define("DEFAULT_FUNCTION", "Index");