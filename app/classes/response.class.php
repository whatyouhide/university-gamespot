<?php
/**
 * This file contains the definition of the Response class.
 */

namespace Http;

/**
 * A wrapper around an HTTP response.
 */
class Response {
  /**
   * @var array An associative array that maps named HTTP error to codes.
   */
  public static $messages_to_status_codes = array(
    'forbidden' => 403,
    'not_found' => 404,
    'internal_server_error' => 500
  );

  /**
   * Translate the given HTTP status message to its respective code.
   *
   * For example, `'not_found'` will become 404.
   * @param string $message
   * @return int
   */
  public static function message_to_status_code($message) {
    return self::$messages_to_status_codes[$message];
  }

  /**
   * Translate the given HTTP status code to its respective message.
   *
   * For example, 500 will become `'internal_server_error'`.
   * @param int $status_code
   * @return string
   */
  public static function status_code_to_message($status_code) {
    return array_search($status_code, self::$messages_to_status_codes);
  }

  /**
   * Set the response code to the given $code.
   * @param int $code
   */
  public static function set_status_code($code) {
    http_response_code($code);
  }
}
?>
