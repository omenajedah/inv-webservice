<?php

class tbl_supplier extends model {
	function __construct() {
		parent::__construct();
		$this->TableName = "tbl_supplier";
		$this->SQLFile = "tbl_supplier.sql";	
	}

	function putData($param) {
		if ($param->DELETE) {
			return $this->deleteData($param);
		}

		if (!$param->kode_supplier) {
			$total = $this->getTable((object)array('fields'=>' COUNT(*) as rowCount'))['rowCount'];
			$total = $total+1;

			if (strlen($total) == 1) {
				$total = '00000'.$total;
			} else if (strlen($total) == 2) {
				$total = '0000'.$total;
			} else if (strlen($total) == 3) {
				$total = '000'.$total;
			}
			$param->kode_supplier = 'S'.$total;
		}
		return parent::putData($param);
	}

}