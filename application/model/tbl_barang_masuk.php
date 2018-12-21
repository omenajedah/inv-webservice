<?php

class tbl_barang_masuk extends model {
	function __construct() {
		parent::__construct();
		$this->TableName = "tbl_barang_masuk";
		$this->SQLFile = "tbl_barang_masuk.sql";	
	}

	function putData($parameter) {
		$this->db->beginTransaction();
		
		$kode_barang = $parameter->kode_barang;
		$tbl_barang = $this->load->model('tbl_barang');

		$barang = $tbl_barang->getData($parameter);

		if (!$barang->RowCount) {
			$total = $tbl_barang->getTable((object)array('table'=>'tbl_barang', 'fields'=>' COUNT(*) as rowCount'))['rowCount'];
			$total = $total+1;

			if (strlen($total) == 1) {
				$total = '00000'.$total;
			} else if (strlen($total) == 2) {
				$total = '0000'.$total;
			} else if (strlen($total) == 3) {
				$total = '000'.$total;
			}
			
			$kode_barang = 'B'.$total;
			$parameter->kode_barang = $kode_barang;
			$result = $tbl_barang->putData($parameter);
		} else {
			$barang = $barang->DataRow[0];
			$param = (array)$parameter;
			$param['jumlah'] = $parameter->jumlah+$barang->jumlah;
			$result = $tbl_barang->putData((object)$param);
		}


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