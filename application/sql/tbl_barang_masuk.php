<?php

$DefaultFields = " * ";
$Where = " WHERE 1 ";
$order = " Order By N_ITENO ";

if ($Fields) {
	$DefaultFields = $Fields;
}

if ($OrderBy) {
	$order = " ORDER BY {$OrderBy}";
}


if ($Mode == "Regular") {
	$SQL = "SELECT $DefaultFields FROM mst_stock_product ";

} else {
	$SQL = "SELECT (*) FROM mst_stock_product";
}

$SQL.=$Where.=$order;