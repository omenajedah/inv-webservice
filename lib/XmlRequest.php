<?php
require_once 'BaseRequest.php';

class XmlRequest extends BaseRequest {

	protected function parseBody($input) {
		return new SimpleXMLElement($input);
	}
}