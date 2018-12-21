<?php

$DefaultFields = " * ";
$Where = " WHERE 1 ";
$order = " Order By kode_mandor ";

if ($Fields) {
	$DefaultFields = $Fields;
}


if ($kode_mandor) {
	$Where .= " AND kode_mandor = '$kode_mandor' ";
}

if ($query) {
	$Where .= " AND kode_mandor LIKE '%{$query}%' OR nama_mandor LIKE '%{$query}%' ";
}

if ($OrderBy) {
	$order = " ORDER BY {$OrderBy}";
}


if ($Mode == "Regular") {
	$SQL = "
	  SELECT $DefaultFields FROM `tbl_mandor`
  ";

} else {
	$SQL = "
	  SELECT COUNT(*) as rowCount FROM `tbl_mandor`
  ";
}



$SQL.=$Where.=$order;

