<?php


class model {

	function __construct() {
		$this->_CONFIG = get_config("configuration.php");
		$this->db = new mysqldb($this->_CONFIG);
		$this->load = new loader();
	}

	function getTable($parameter) {
		$data = array('table' =>  $this->TableName, "fields" => "*");
		if ($parameter->fields)
			$data['fields'] = $parameter->fields;
		if ($parameter->criteria)
			$data['criteria'] = $parameter->criteria;
		if ($parameter->groupBy)
			$data['groupBy'] = $parameter->groupBy;
		if ($parameter->orderBy)
			$data['orderBy'] = $parameter->orderBy;
		if ($parameter->table) {
			$data['table'] = $parameter->table;
		}
		return $this->db->getTable($data);
	}

	function getFields($parameter) {
		return $this->db->getFields($this->TableName);
	}

	function getPrimaryKey($parameter) {
		return $this->db->getPrimaryKey($this->TableName);
	}

	function getData($parameter) {
		$result = array();

		if (!isset($parameter->Mode)) 
			$parameter->Mode = 'Regular';

		if ($parameter->Mode == 'Regular') {
			$retData = $this->db->QueryMulti($this->load->sql($this->SQLFile, $parameter));

			if (!$retData['0'] && count($retData)) {
				$val = $retData;
				$retData = array(0=>$val);
			}
			$retData = json_decode(json_encode($retData));
			$result['DataRow'] = $retData;
		}

		$parameter->Mode = "Count";
		$rowCount = $this->db->QueryMulti($this->load->sql($this->SQLFile, $parameter));
		$result['RowCount'] = $rowCount['rowCount'];

		return (object)$result;
	}

	function putData($parameter) {
		// $data = array('table' =>  $this->TableName, "fields" => "*");
		$primaryKey = $this->db->getPrimaryKey($this->TableName);

		for ($i=0; $i < count($primaryKey); $i++) {
			if ($parameter->{$primaryKey[$i]}) {
				$hasPrimaryKey = true;
				break;
			}
		}

		if ($hasPrimaryKey) {
			$criteria = " 1 ";

			foreach ($primaryKey as $key => $value) {
				if (isset($parameter->{$value})) {
					$criteria.=" AND {$value} = '{$parameter->$value}' ";
				}
			}

			$param = array('table' =>  $this->TableName, "fields" => implode(",", $primaryKey), "criteria" => $criteria);
			$data = $this->db->getTable($param);
			if ($data) {
				return $this->setData($parameter);
			}
		}
		$retData = $this->db->insert($this->TableName, (array)$parameter);
		
		return (object)$retData;
	}

	function setData($parameter) {
		$retData = $this->db->update($this->TableName, (array)$parameter);

		return (object)$retData;
	}

	function deleteData($parameter) {
		$result = array('success'=>false);

		$primaryKey =$this->getPrimaryKey($parameter);

		foreach ($primaryKey as $key => $value) {
			if ($parameter->{$value}) {
				$criteria.=" AND {$value} = '{$parameter->$value}' ";
			}
		}

		if ($criteria) {
			$SQL = "DELETE FROM $this->TableName WHERE 1 ";
			$this->db->execute($SQL.$criteria);
			$result['success'] = true;
		}

		return $result;
	}

	function Index() {
		var_dump($this);
	}

}

?>