<?php
/**
 * This file contains the definition of the Db class.
 */

namespace Common;

use mysqli;

/**
 * This class is an interface to the underlying db.
 */
class Db {
  /**
   * @var object A mysqli connection object.
   */
  public static $connection = NULL;

  /**
   * Initialize the db connection and raise an exception if something goes
   * wrong.
   * @throws Exception If something goes wrong with the db.
   */
  public static function init() {
    $options = $GLOBALS['config']['database'];

    self::$connection = new mysqli(
      $options['host'],
      $options['user'],
      $options['password'],
      $options['db']
    );

    self::throw_exception_if_error();
  }

  /**
   * Issue a query to the db.
   * @param string $query
   */
  public static function query($query) {
    $result = self::$connection->query($query);
    self::throw_exception_if_error();
    return $result;
  }

  /**
   * Extract rows as an array from a query.
   * @param string $query
   */
  public static function get_rows($query) {
    return self::query_to_rows(self::query($query));
  }

  /**
   * Return the id of the last inserted record.
   * @return int The id of the last inserted record.
   */
  public static function last_insert_id() {
    return self::$connection->insert_id;
  }

  /**
   * Return a MySQL friendly timestamp of now for use in DATETIME fields.
   * @return string
   */
  public static function datetime() {
    return date('Y-m-d H:i:s');
  }

  /**
   * Escape a string to sanitize input.
   * @param string $str The string to escape.
   * @return string The escaped string.
   */
  public static function escape($str) {
    return self::$connection->real_escape_string($str);
  }

  /**
   * Convert the result of a query to an array (rows).
   * @param mixed $query_result The result of a mysqli query.
   * @return array An array of rows.
   */
  private static function query_to_rows($query_result) {
    $rows = array();

    if (!$query_result) return $rows;

    for ($row_no = 0; $row_no < $query_result->num_rows; $row_no++) {
      $query_result->data_seek($row_no);
      $row = $query_result->fetch_assoc();
      array_push($rows, $row);
    }

    return $rows;
  }

  /**
   * Throw an an exception if there has been a connection error.
   * @throws Exception
   */
  private static function throw_exception_if_error() {
    $error = self::$connection->error;

    if ($error) {
      throw new Exception("Error with the database: $error");
    }
  }
}
?>
