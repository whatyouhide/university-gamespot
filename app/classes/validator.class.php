<?php
/**
 * This file contains the definition of the Validator class.
 */

/**
 * A class that provides validation utilities.
 * Each method of this class accepts a message as its last argument, which will
 * be attached to an array of error messages that can be requested to the
 * Validator instance with the error_messages() method.
 * @package Gamespot
 * @subpackage Models
 */
class Validator {
  /**
   * @var array An associative array of attributes.
   */
  private $attrs;

  /**
   * @var array A list fo error messages.
   */
  private $messages;

  const DATE_REGEX = '/\d{1,2}\/\d{1,2}\/\d{4}/';

  /**
   * Create a new instance based on an array of $attributes.
   * @param array $attributes
   */
  public function __construct($attributes) {
    $this->attrs = $attributes;
    $this->messages = array();
  }

  /**
   * Add an error message if the $key in this instance's attributes is present
   * and empty.
   * @param string $key
   * @param string $msg
   */
  public function must_not_be_empty($key, $msg = null) {
    $empty = $this->is_set($key) && empty($this->attrs[$key]);

    if (is_null($msg)) {
      $msg = ucfirst($key) . " can't be empty";
    }

    $this->add_message_if($empty, $msg);
  }

  /**
   * Add an error message if the value at $key is not a number.
   * @param string $key
   * @param string $msg
   */
  public function must_be_int($key, $msg) {
    if (!$this->is_set($key)) { return; }

    $is_int = ctype_digit($this->attrs[$key]);

    if (is_null($msg)) {
      $msg = ucfirst($key) . " is not a number";
    }

    $this->add_message_if(!$is_int, $msg);
  }

  /**
   * Add an error message if the value at $key isn't a valid email.
   * @param string $key
   * @param string $msg
   */
  public function must_be_valid_email($key, $msg = null) {
    if (!$this->is_set($key)) { return; }

    if (is_null($msg)) {
      $msg = "Email {$this->attrs[$key]} is invalid";
    }

    $valid = filter_var($this->attrs[$key], FILTER_VALIDATE_EMAIL);
    $this->add_message_if(!$valid, $msg);
  }

  /**
   * Add an error message if the value at $key is not a valid date.
   * @param string $key
   * @param string $msg
   */
  public function must_be_valid_date($key, $msg) {
    if (!$this->is_set($key)) { return; }

    $valid_date = preg_match(DATE_REGEX, $this->attrs[$key]);

    if (is_null($msg)) {
      $msg = ucfirst($key) . " is not a valid date";
    }

    $this->add_message_if(!$valid_date, $msg);
  }

  /**
   * Return a list of all the error messages.
   * @return array
   */
  public function error_messages() {
    return $this->messages;
  }

  /**
   * Returns true if the attribute at $key is set.
   * @param string $key
   * @return bool
   */
  private function is_set($key) {
    return isset($this->attrs[$key]);
  }

  /**
   * Add an error message to this instance if $condition is true.
   * @param bool $condition
   * @param string $msg
   */
  private function add_message_if($condition, $msg) {
    if ($condition) {
      $this->messages[] = $msg;
    }
  }
}
?>
