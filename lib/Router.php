<?php
class Router {
  private $request;
  private $supportedHttpMethods = array(
    "GET",
    "POST"
  );

  function __construct(BaseRequest $request) {
    $this->request = $request;
    $this->request->prepare();
  }
 
  function __call($name, $args) {
    list($route, $method) = $args;
    if(!in_array(strtoupper($name), $this->supportedHttpMethods)) {
      $this->methodNotAllowed();
    }
    $rt = $this->formatRoute($route);
    $this->{strtolower($name)}[$rt] = $method;
   }
  /**
   * Removes trailing forward slashes from the right of the route.
   * @param route (string)
   */
  private function formatRoute($route) {
    $result = rtrim($route, '/');
    if ($result === '') {
      return '/';
    }
    $result = preg_replace('/\?.*/', '', $result);
    return $result;
  }

  public function unauthorized() {
    header("{$this->request->serverProtocol} 401 Unauthorized");
  }

  public function forbidden() {
    header("{$this->request->serverProtocol} 403 Forbidden");
  }

  public function notFound() {
    header("{$this->request->serverProtocol} 404 Not Found");
  }

  public function methodNotAllowed() {
    header("{$this->request->serverProtocol} 405 Method Not Allowed");
  }
  
  public function unsupportedMediaType() {
    header("{$this->request->serverProtocol} 415 Unsupported Media Type");
  }


 
  private function isJson($string) {
   json_decode($string);
   return (json_last_error() == JSON_ERROR_NONE);
  }
  /**
   * Resolves a route
   */
  private function resolve() {
    if (!in_array(strtoupper($this->request->requestMethod), $this->supportedHttpMethods)) {
      $this->methodNotAllowed();
      exit;
    }
    $methodDictionary = $this->{strtolower($this->request->requestMethod)};
    $formatedRoute = $this->formatRoute(str_replace(ROOT_PATH, "", $this->request->requestUri));

    if (!$formatedRoute) {
      $formatedRoute = "/";
    }


    if (!isset($methodDictionary[$formatedRoute])) {
      $this->notFound();
      return;
    }
    $method = $methodDictionary[$formatedRoute];

    if(is_null($method)) {
      $this->notFound();
      return;
    }
    
    $retData =  call_user_func_array($method, array($this->request));

    if ($retData) {

      if (is_object($retData)) {
        $retData = (array) $retData;
      }

      if (is_array($retData)) {
        $retData = json_encode($retData);
      }

      if ($this->isJson($retData)) {
        header('Content-Type: application/json');
      }
      echo $retData;
    }
  }

  function run() {
    $this->resolve();
  }
}