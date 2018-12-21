<?php

class tbl_barang_keluar extends model {
	function __construct() {
		parent::__construct();
		$this->TableName = "tbl_barang_keluar";
		$this->SQLFile = "tbl_barang_keluar.sql";	
	}

	function putData($parameter) {
		$this->db->beginTransaction();

		$kode_barang = $parameter->kode_barang;
		$tbl_barang = $this->load->model('tbl_barang');

		$barang = $tbl_barang->getData($parameter);

		if (!$barang->RowCount) {
			return array('success'=>false, 'reason'=>'Produk tidak ditemukan.');
		}

		$barang = $barang->DataRow[0];
		$param = (array)$parameter;
		$param['jumlah'] = $barang->jumlah-$parameter->jumlah;
		$result = $tbl_barang->putData((object)$param);

		if (!$result->success) {
			$this->db->rollbackTransaction();
			return array('success'=>false, 'reason'=>'Telah terjadi error, silahkan coba lagi.');
		}

		$res = parent::putData($parameter);

		if (!$res->success) {
			$this->db->rollbackTransaction();
			return array('success'=>false, 'reason'=>'Telah terjadi error, silahkan coba lagi.');
		}


		$this->db->commitTransaction();

		return $result;
	}






}