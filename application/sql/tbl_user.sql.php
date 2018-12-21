<?php

$DefaultFields = "*";
$Where = " WHERE 1 ";
$order = " Order By user_name ;";

if ($Fields) {
	$DefaultFields = $Fields;
}

$Where.=" AND user_name = '$user_name' ";
$Where.=" AND user_pass = '$user_pass' ";


if ($OrderBy) {
	$order = " ORDER BY {$OrderBy}";
}


if ($Mode == "Regular") {
	$SQL = "SELECT $DefaultFields FROM tbl_user
		";

} else {
	$SQL = "SELECT COUNT(*) as rowCount FROM tbl_user
		";
}

$SQL.=$Where.=$order;
