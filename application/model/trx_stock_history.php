<?php

class trx_stock_history extends model {
	function __construct() {
		parent::__construct();
		$this->TableName = "trx_stock_history";
		$this->SQLFile = "trx_history_saldo.sql";
	}




}