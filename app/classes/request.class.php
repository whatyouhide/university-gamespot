<?php
class Request {
  /**
   * Create a new Request object and set the `params` instance variable based on
   * the request method.
   */
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

  /**
   * Whether the request is a GET one.
   * @return bool True if the request is a GET, false otherwise
   */
  public function is_get() {
    return $this->method() == 'GET';
  }

  /**
   * Whether the request is a POST one.
   * @return bool True if the request is a POST, false otherwise
   */
  public function is_post() {
    return $this->method() == 'POST';
  }

  /**
   * Extract the request method from the CGI $_SERVER array.
   * @return string The request method
   */
  public function method() {
    return $_SERVER['REQUEST_METHOD'];
  }
}
?>
