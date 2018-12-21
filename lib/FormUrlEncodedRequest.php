<?php
require_once 'BaseRequest.php';

class FormUrlEncodedRequest extends BaseRequest {

	protected function parseBody($input) {
		$result = array();
		foreach($_POST as $key => $value) {
			$result[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
		}
		unset($_POST);
		return $result;
	}
}