<?php

class mst_product extends model {
	function __construct() {
		parent::__construct();
		$this->TableName = "mst_product";
		$this->SQLFile = "mst_product.sql";	
	}




}