<?php

class Response {

	function __construct($protocol, $responseCode, $responseMessage, $header = array(), $response = NULL) {
		$this->protocol = $protocol;
		$this->responseCode = $responseCode;
		$this->responseMessage = $responseMessage;
		$this->header = $header;
		$this->response = $response;
		$this->process();
	}

	function process() {
		header("$this->protocol $this->responseCode $this->responseMessage");
		foreach ($this->header as $key => $value) {
			header("$key: $value");
		}
		if ($this->response) {
			print $this->response;
		}
	}

	public static function newResponse(BaseRequest $request) {
		
	}
}