<?php

class tbl_barang extends model {
	function __construct() {
		parent::__construct();
		$this->TableName = "tbl_barang";
		$this->SQLFile = 'tbl_barang.sql';
	}

}