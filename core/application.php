<?php
class application {

	function __construct() {
		$this->_CONFIG = get_config("configuration.php");
		$this->startup();
	}

	function startup() {
		$this->requestHandler = array();
		$this->load = new loader();
		$this->db = new mysqldb($this->_CONFIG);
	}

	function Business() {
		$model = $this->load->model($_GET['_m']);
		$function = isset($_GET['_f']) ? $_GET['_f'] : 'Index';

		$param = $_POST;

		if ($model == null) {
			http_response_code(400);
			echo "Bad Request";
			exit;
		}

		if (!method_exists($model, $function)) {
			http_response_code(400);
			echo "Bad Request";
			exit;
		}
		$result = $model->{$function}($param);

		header("Content-Type: application/json");
		echo json_encode($result);
		
	}

	function Index() {
		echo "Congratulations, Web Service Running.";
	}

	function __call($name, $args) {
		$this->cekRouter();
		if (count($args)) {
    		list($route, $method) = $args;
			$this->router->{strtolower($name)}($route, $method);
		} else
			$this->router->{$name}();
	}

	private function cekRouter() {
		if (!isset($this->router)) {
			$contentType = $_SERVER['CONTENT_TYPE'];
			$canHandle = false;

			foreach ($this->requestHandler as $key => $value) {
				if (strpos($contentType, $key) !== false) {
					$canHandle = true;
					$contentType = $key;
					break;
				}
			}

			if ($_SERVER['REQUEST_METHOD'] == 'GET') {
				$contentType = "application/x-www-form-urlencoded";
			}

			if (!isset($this->requestHandler[$contentType])) {
				header('HTTP/1.1 415 Unsupported Media Type');
				die;
			}
			$this->router = new Router($this->requestHandler[$contentType]);
		}
	}

	function addRequestHandler($contentType, $requestHandler) {
		$this->requestHandler[$contentType] = $requestHandler;
	}

	function run() {
		$this->router->run();
	}
}
?>