<?php

$DefaultFields = "kode_barang, `nama_barang`, `jumlah`, `satuan_barang` ";
$Where = " WHERE 1 ";
$order = " Order By kode_barang ;";

if ($Fields) {
	$DefaultFields = $Fields;
}



if ($kode_barang) {
	$Where .= " AND kode_barang = '$kode_barang' ";
}

if ($query) {
	$Where .= " AND kode_barang LIKE '%{$query}%' OR nama_barang LIKE '%{$query}%' ";
}

if ($OrderBy) {
	$order = " ORDER BY {$OrderBy};";
}


if ($Mode == "Regular") {
	$SQL = "SELECT $DefaultFields FROM `tbl_barang` ";

} else {
	$SQL = "SELECT COUNT(*) as rowCount FROM `tbl_barang` ";
}



$SQL.=$Where.=$order;