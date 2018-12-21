<?php

$DefaultFields = "*";
$Where = " WHERE 1 ";
$order = " Order By C_CATEGORY_ID ";

if ($Fields) {
	$DefaultFields = $Fields;
}



if ($C_CATEGORY_ID) {
	$Where .= " AND C_CATEGORY_ID = '$C_CATEGORY_ID' ";
}

if ($C_CATEGORY_NAME) {
	$Where .= " AND C_CATEGORY_NAME = '$C_CATEGORY_NAME' ";
}

if ($query) {
	$Where .= " AND C_CATEGORY_ID LIKE '%{$query}%' OR C_CATEGORY_NAME LIKE '%{$query}%' ";
}

if ($OrderBy) {
	$order = " ORDER BY {$OrderBy}";
}


if ($Mode == "Regular") {
	$SQL = "SELECT $DefaultFields FROM mst_category ";

} else {
	$SQL = "SELECT Count(*) AS rowCount FROM mst_category ";
}



$SQL.=$Where.=$order;

