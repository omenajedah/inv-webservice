<?php

$DefaultFields = " a.N_ITENO, a.N_PRICE, b.C_TYPE, b.V_DESC, a.D_VALID, a.D_EXPIRED, a.C_STATUS ";
$Where = " WHERE 1 ";
$order = " Order By a.`N_ITENO` ";

if ($Fields) {
	$DefaultFields = $Fields;
}


if ($N_ITENO) {
	$Where .= " AND a.`N_ITENO` = '$N_ITENO' ";
}

if ($C_TYPE) {
	$Where .= " AND a.`C_TYPE` = '$C_TYPE' ";
}

if ($C_STATUS) {
	$Where .= " AND a.`C_STATUS` = '$C_STATUS' ";
}

if ($OrderBy) {
	$order = " ORDER BY {$OrderBy}";
}


if ($Mode == "Regular") {
	$SQL = "SELECT $DefaultFields
			FROM `mst_price` a 
			JOIN mst_price_type b ON a.`C_TYPE` = b.`C_TYPE`
  ";

} else {
	$SQL = "SELECT COUNT(*) as rowCount
			FROM `mst_price` a 
			JOIN mst_price_type b ON a.`C_TYPE` = b.`C_TYPE`
  ";
}



$SQL.=$Where.=$order;

