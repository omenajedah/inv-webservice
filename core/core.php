<?php

if (!isset($_GET[MODULE_NAME])) {
	$_GET[MODULE_NAME] = DEFAULT_CONTROLLER;
}

if (!isset($_GET[METHOD_NAME])) {
	$_GET[METHOD_NAME] = DEFAULT_FUNCTION;
}
$app_file = str_replace(".", "/", $_GET[MODULE_NAME]);
if (!file_exists('application/'.$app_file.'.php')) {
	http_response_code(400);
	echo "Bad Request";
	exit;
}
include('application/'.$app_file.'.php');
$app_name = explode("/", $app_file);
$app_name = $app_name[count($app_name)-1];
$function_name = $_GET[METHOD_NAME];

$app = new $app_name();
if (!method_exists($app, $function_name)) {
	http_response_code(400);
	echo "Bad Request";
	exit;
}
$app->{$function_name}();