<?php

class tbl_mandor extends model {
	function __construct() {
		parent::__construct();
		$this->TableName = "tbl_mandor";
		$this->SQLFile = "tbl_mandor.sql";	
	}

	function putData($param) {
		if ($param->DELETE) {
			return $this->deleteData($param);
		}
		return parent::putData($param);
	}


}