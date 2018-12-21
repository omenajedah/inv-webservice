<?php
require_once 'BaseRequest.php';

class FormDataRequest extends BaseRequest {

	protected function parseBody($input) {
		$result = array();
		$i=0;
		foreach($_FILES as $key => $value) {
			$result[$i] = $value;
			$i++;
		}
		return $result;
	}
}