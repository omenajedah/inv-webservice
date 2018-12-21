<?php

class mysqldb {

	function __construct($dbconfig) {
		$this->Connection = mysqli_connect($dbconfig['hostname'], $dbconfig['username'], $dbconfig['password'], $dbconfig['database']);

		if ($this->Connection->connect_error) {
    		die("Connection failed: " . $conn->connect_error);
		}
	}

	function beginTransaction() {
		mysqli_autocommit($this->Connection, FALSE);
	}

	function rollbackTransaction() {
		mysqli_rollback($this->Connection);
	}

	function commitTransaction() {
		mysqli_commit($this->Connection);
	}

	function getPrimaryKey($table, $type="Field") {
		$fields = $this->getFields($table);
		$i=0;
		$retData = array();
		foreach ($fields as $key => $value) {
			if ($value['Key'] == "PRI") {
				if ($type == "Field")
					$retData[$i] = $value['Field'];
				else 
					$retData[$i] = $value;
				$i++;
			}
		}
		return $retData;
	}

	function getFields($table) {
		$SQL = "SHOW FIELDS FROM $table ";
		return $this->query($SQL);
	}

	function getTable($parameter) {
		$SQL = "SELECT {$parameter['fields']} FROM {$parameter['table']} ";
		$SQLWhere = ' WHERE 1 ';
		if ($parameter['criteria']) {
			$SQLWhere .= " AND {$parameter['criteria']} ";
		}

		if ($parameter['groupBy']) {
			$SQLGroupBy = " GROUP BY {$parameter['groupBy']} ";
		}

		if ($parameter['orderBy']) {
			$SQLOrderBy = " ORDER BY {$parameter['orderBy']} ";
		}

		if ($parameter['limit']) {
			$SQLLimit = "  LIMIT {$parameter['limit']} ";
		}

		return $this->query($SQL.$SQLWhere.$SQLGroupBy.$SQLOrderBy.$SQLLimit);
	}

	function parseSQL($sql,$delimeter=";") {
	    $queries = explode(";", $sql);
	    $SQL = array();

    	for ($i=0;$i<count($queries);$i++) {
            if (strlen(trim($queries[$i])) > 0) $SQL[] = $queries[$i];
        }
    	return $SQL;
	}

	function queryMulti($SQL) {
	    if (!$SQL) return;
	    if (!is_array($SQL))
	    	$SQL = $this->parseSQL($SQL);

	    if (is_array($SQL)) {
	    	for ($i=0;$i<count($SQL);$i++) {
				$QueryResult = $this->query($SQL[$i]);
				$errorNo = $this->Connection->errno;
				$errorMsg = $this->Connection->error;
				if($errorNo>0) error_log("ERROR LoadQuery($sqlfile): {$errorNo}-{$errorMsg} \r\n ");
	        }
	    } else {
	    	$QueryResult = $this->query($SQL[$i]);
			$errorNo = $this->Connection->errno;
			$errorMsg = $this->Connection->error;
			if($errorNo>0) error_log("ERROR LoadQuery($sqlfile): {$errorNo}-{$errorMsg} \r\n ");
		}
		return $QueryResult;
	}

	function query($SQL) {
		$mysqlresult = mysqli_query($this->Connection, $SQL);
		$result = array();

		if ($mysqlresult !== FALSE) {
			if (isset($mysqlresult->num_rows)) {
				if ($mysqlresult->num_rows > 1) {
					$i=0;
					while ($row = mysqli_fetch_assoc($mysqlresult)) {
						$result[$i] = $row;
						$i++;
					}
				} else if ($mysqlresult->num_rows == 1)
					$result = mysqli_fetch_assoc($mysqlresult);

				mysqli_free_result($mysqlresult);
				return $result;
			}
			return;
		}
		echo ("Error: ".$this->Connection->error);
	}

	function execute($SQL) {
		$stmt = mysqli_prepare($this->Connection, $SQL);

		$mysqlresult = mysqli_stmt_execute ($stmt);

		return $mysqlresult;
	}

	function insert($table, $values) {
		$result = array("success"=>false);
		$fields = $this->getFields($table);
		$field = "";
		$value = "";
		foreach ($fields as $key => $val) {
			if (isset($values[$val['Field']])) {
				if ($field)
					$field.=",";
				if ($value)
					$value.=",";

				$field.=$val['Field'];
				$value.="'".$values[$val['Field']]."'";
			}
		}

		$SQL = "INSERT INTO {$table} ({$field}) VALUES ({$value})";

		$mysqlresult = mysqli_query($this->Connection, $SQL);
		if ($mysqlresult)
			$result['success'] = true;

		if ($this->lastInsertId() != 0)
			$result['LastInsertId'] = $this->lastInsertId();
		else {
			$result['LastInsertId'] = array();
			foreach ($this->getPrimaryKey($table) as $key => $value) {
				if ($values[$value]) {
					array_push($result['LastInsertId'], array($value=>$values[$value]));			
				}
			}

			if (count($result['LastInsertId']) == 0) {
				unset($result['LastInsertId']);
			}
		}
		return $result;
	}

	function update($table, $values, $blockIfNoPrimary = TRUE) {
		$fields = $this->getFields($table);

		$set = "";
		$where = " WHERE 1 ";
		$hasPrimary = FALSE;
		foreach ($fields as $key => $val) {
			if ($val['Key'] == "PRI" && isset($values[$val['Field']])) {
				$where.=" AND {$val['Field']} = '{$values[$val['Field']]}' ";
				$hasPrimary = TRUE;
			} else if (isset($values[$val['Field']])) {
				if ($set)
					$set.=",";
				$set.=$val['Field']."='".$values[$val['Field']]."'";
			}
		}

		if (!$hasPrimary && $blockIfNoPrimary) {
			return array("success"=>false);
		}

		$SQL = "UPDATE $table SET $set $where";

		$mysqlresult = mysqli_query($this->Connection, $SQL);
		if ($mysqlresult)
			$result['success'] = true;
			
		return array("success"=>true);
	}

	function lastInsertId() {
		return  mysqli_insert_id($this->Connection);
	}
}