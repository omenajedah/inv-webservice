<?php
require_once 'BaseRequest.php';

class JsonRequest extends BaseRequest {
  
	protected function parseBody($input) {
		return json_decode($input, true);
	}
}