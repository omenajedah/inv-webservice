<?php

$DefaultFields = " * ";
$Where = " WHERE 1 ";
$order = " Order By kode_supplier ";

if ($Fields) {
	$DefaultFields = $Fields;
}


if ($kode_supplier) {
	$Where .= " AND kode_supplier = '$kode_supplier' ";
}

if ($query) {
	$Where .= " AND kode_supplier LIKE '%{$query}%' OR nama_supplier LIKE '%{$query}%' ";
}

if ($OrderBy) {
	$order = " ORDER BY {$OrderBy}";
}


if ($Mode == "Regular") {
	$SQL = "
	  SELECT $DefaultFields FROM `tbl_supplier`
  ";

} else {
	$SQL = "
	  SELECT COUNT(*) as rowCount FROM `tbl_supplier`
  ";
}



$SQL.=$Where.=$order;

