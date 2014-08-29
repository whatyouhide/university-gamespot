<?php
/**
 * This file contains the definition of the Request class.
 */

namespace Http;

/**
 * An abstraction over an HTTP request.
 * @package Gamespot
 * @subpackage Common
 */
class Request {
  /**
   * Create a new Request object and set the `params` instance variable based on
   * the request method.
   */
  public function __construct() {
    $this->params = array_merge($_GET, $_POST);
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
   * Extract and return the request method from the CGI `$_SERVER` array.
   * @return string
   */
  public function method() {
    return $_SERVER['REQUEST_METHOD'];
  }

  /**
   * Return the path of the current request (the REQUEST_URI) stripped of the
   * initial relative path (specified in `config.ini`).
   * Example:
   * <code>'/gamespot/test_path' => '/test_path'</code>
   *
   * @return string
   */
  public static function path() {
    $relative_path = $GLOBALS['config']['site']['relative_path'];
    $pattern = '/' . preg_quote($relative_path, '/') . '/';
    return preg_replace($pattern, '', $_SERVER['REQUEST_URI'], 1);
  }

  /**
   * Return the value of an HTTP request header.
   * @param string $header_name The name of the header.
   * @return string
   */
  public static function headers($header_name) {
    $cgi_header = "HTTP_" . strtoupper($header_name);
    return $_SERVER[$cgi_header];
  }
}
?>
