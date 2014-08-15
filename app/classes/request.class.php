<?php
class Request {
  // Set the `params` instance variable according to the request type.
  public function __construct() {
    switch($this->method()) {
    case 'GET':
      $this->params = $_GET;
      break;
    case 'POST':
      $this->params = $_POST;
      break;
    }
  }

  // Whether the request is a GET one.
  public function is_get() {
    return $this->method() == 'GET';
  }

  // Whether the request is a POST one.
  public function is_post() {
    return $this->method() == 'POST';
  }

  // Private methods

  // Extract the request type from the $_SERVER superglobal.
  private function method() {
    return $_SERVER['REQUEST_METHOD'];
  }
}
?>
