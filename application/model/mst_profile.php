<?php

class mst_profile extends model {
	function __construct() {
		parent::__construct();
		$this->TableName = "mst_profile";
		$this->SQLFile = "mst_profile.sql";	
	}




}