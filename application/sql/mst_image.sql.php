<?php

$DefaultFields = " T_IMAGE ";
$Where = " WHERE 1 ";
$order = " Order By `C_IMAGE_PATH` ";

if ($Fields) {
	$DefaultFields = $Fields;
}


if ($C_IMAGE_PATH) {
	$Where .= " AND `C_IMAGE_PATH` = '$C_IMAGE_PATH' ";
}

if ($C_IMAGE_NAME) {
	$Where .= " AND `C_IMAGE_NAME` = '$C_IMAGE_NAME' ";
}

if ($OrderBy) {
	$order = " ORDER BY {$OrderBy}";
}


if ($Mode == "Regular") {
	$SQL = "
	  SELECT $DefaultFields FROM mst_image
  ";

} else {
	$SQL = "
	  SELECT COUNT(*) as rowCount FROM mst_image
  ";
}



$SQL.=$Where.=$order;

