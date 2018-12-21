<?php

class trx_laporan extends model {
	function __construct() {
		parent::__construct();
		$this->TableName = "trx_laporan";
		$this->SQLFile = "trx_laporan.sql";	
	}




}