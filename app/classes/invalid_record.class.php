<?php
/**
 * This file contains the definition of the InvalidRecord class.
 */

namespace Models;

/**
 * A fake Model class which responds only to the `is_valid` and `errors`
 * methods. This is used so that the Model class can return an instance of
 * InvalidRecord when the creation of a real record fails and we don't have
 * anything in the db.
 */
class InvalidRecord {
  /**
   * @var array An array of error messages, just like in the Model class.
   */
  private $errors;

  /**
   * Create a new instance based on the errors in `$errors`.
   * @param array $errors
   */
  public function __construct($errors) {
    $this->errors = $errors;
  }

  /**
   * An InvalidRecord is invalid by definition, so this function always returns
   * false.
   * @return bool
   */
  public function is_valid() {
    return false;
  }

  /**
   * Return the list of errors attached to this instance (this function mimics
   * Model::errors()).
   * @return array
   */
  public function errors() {
    return $this->errors;
  }

  /**
   * Return all the errors as a single string.
   * @return string
   */
  public function errors_as_string() {
    return implode(', ', $this->errors());
  }
}
?>
