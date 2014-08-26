<?php
/**
 * This file contains the definition of the Db class.
 */

/**
 * This class is an interface to the underlying db.
 * @package Gamespot
 * @subpackage Common
 */
class Db {
  /**
   * @var object A mysqli connection object.
   */
  public static $connection = NULL;

  /**
   * @var array Options to connect to the MySQL db.
   */
  public static $options = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => 'root',
    'db' => 'gamespot',
    'port' => 3306
  ];

  /**
   * Initialize the db connection and raise an exception if something goes
   * wrong.
   * @throws Exception If something goes wrong with the db.
   */
  public static function init() {
    self::$connection = new mysqli(
      self::$options['host'],
      self::$options['user'],
      self::$options['password'],
      self::$options['db'],
      self::$options['port']
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
