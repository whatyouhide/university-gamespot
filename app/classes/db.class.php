<?php
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
   */
  public static function init() {
    self::$connection = new mysqli(
      self::$options['host'],
      self::$options['user'],
      self::$options['password'],
      self::$options['db'],
      self::$options['port']
    );

    self::throw_connection_error_if_present();
  }

  /**
   * Issue a query to the db.
   * @param string $q The query to issue.
   */
  public static function query($q) {
    return self::$connection->query($q);
  }

  /**
   * Extract rows as an array from a query.
   * @param string $q The query to retrieve the rows.
   */
  public static function get_rows($q) {
    return self::query_to_rows(self::query($q));
  }

  /**
   * Return the id of the last inserted record.
   * @return int The id of the last inserted record.
   */
  public static function last_insert_id() {
    return self::$connection->insert_id;
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
   */
  private static function throw_connection_error_if_present() {
    $error = self::$connection->error;
    if ($error) {
      $number = self::$connection->errno;
      $msg = "Unable to connect to the db ($number): $error";
      throw new Exception($msg);
    }
  }
}
?>
