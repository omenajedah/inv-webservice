<?php

$DefaultFields = "*";
$Where = " WHERE 1 ";
$order = " Order By a.kode_barang ";

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
	$order = " ORDER BY a.{$OrderBy};";
}


if ($Mode == "Regular") {
	$SQL = "SELECT $DefaultFields FROM (
				SELECT b.`id_trans`, a.kode_barang, a.`nama_barang`, b.`jumlah`, a.`satuan_barang`, b.`waktu`, b.`keterangan`, c.`nama_supplier` , 1 AS C_TYPE FROM `tbl_barang` a
				JOIN `tbl_barang_masuk` b ON a.`kode_barang` = b.`kode_barang`
				JOIN `tbl_supplier` c ON b.`kode_supplier` = c.`kode_supplier`
				UNION
				SELECT b.`id_trans`, a.kode_barang, a.`nama_barang`, b.`jumlah`, a.`satuan_barang`, b.`waktu`, b.`keterangan`, c.`nama_mandor` , -1 AS C_TYPE FROM `tbl_barang` a
				JOIN `tbl_barang_keluar` b ON a.`kode_barang` = b.`kode_barang`
				JOIN `tbl_mandor` c ON b.`kode_mandor` = c.`kode_mandor`
			) a ";

} else {
	$SQL = "SELECT COUNT(*) as rowCount FROM (
				SELECT b.`id_trans`, a.kode_barang, a.`nama_barang`, b.`jumlah`, a.`satuan_barang`, b.`waktu`, b.`keterangan`, c.`nama_supplier` , 1 AS C_TYPE FROM `tbl_barang` a
				JOIN `tbl_barang_masuk` b ON a.`kode_barang` = b.`kode_barang`
				JOIN `tbl_supplier` c ON b.`kode_supplier` = c.`kode_supplier`
				UNION
				SELECT b.`id_trans`, a.kode_barang, a.`nama_barang`, b.`jumlah`, a.`satuan_barang`, b.`waktu`, b.`keterangan`, c.`nama_mandor` , -1 AS C_TYPE FROM `tbl_barang` a
				JOIN `tbl_barang_keluar` b ON a.`kode_barang` = b.`kode_barang`
				JOIN `tbl_mandor` c ON b.`kode_mandor` = c.`kode_mandor`
			) a ";
}



$SQL.=$Where.=$order;

