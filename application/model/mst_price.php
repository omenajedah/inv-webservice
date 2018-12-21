<?php

class mst_price extends model {
	function __construct() {
		parent::__construct();
		$this->TableName = "mst_price";
		$this->SQLFile = "mst_price.sql";	
	}




}