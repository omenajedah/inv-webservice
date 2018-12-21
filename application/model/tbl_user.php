<?php

class tbl_user extends model {
	function __construct() {
		parent::__construct();
		$this->TableName = "tbl_user";
		$this->SQLFile = "tbl_user.sql";	
	}




}