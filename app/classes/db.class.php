<?php

// Wrapper around the underlying db. This class abstracts all the db implementation
// (in this case `mysqli` behavior needed in the application.
class DB {

  // A `connection` property which will be instanciated to a `mysqli` instance
  public $connection = NULL;

  // Create a new object and set its `connection` property by creating a new
  // mysqli instance which is connected to te MySQL db.
  function __construct() {
    $this->connection = new mysqli( 'localhost', 'root', 'root', 'gamespot', 3306 );
    $error = $this->connection->error;
    if ( $error ) {
      throw new Exception("Unable to connect to the db ({$db->connection->errno}): {$error}");
    }
  }

  // Execute a query on the underlying db
  public function query($q) {
    return $this->connection->query($q);
  }

  // Transform the result of a previously executed query into an array of rows.
  public function query_to_rows($query_result) {
    $rows = array();

    if (!$query_result) return $rows;

    for ($row_no = 0; $row_no < $query_result->num_rows; $row_no++) {
      $query_result->data_seek($row_no);
      $row = $query_result->fetch_assoc();
      array_push($rows, $row);
    }

    return $rows;
  }

  // Get the rows associated with the query `$q`
  public function get_rows($q) {
    $res = $this->query($q);
    return $this->query_to_rows($res);
  }

  // Retrieve the error number of the underlying db
  public function get_error_no() {
    return $this->connection->errno;
  }

  // Retrieve the error of the underlying fb
  public function get_error() {
    return $this->connection->error;
  }

  // Returns true if the result of a previously executed query is empty.
  public function is_empty_query( $res ) {
    return $res->num_rows == 0;
  }

  // Returns the `id` of the last inserted element (via an INSERT INTO).
  public function last_insert_id() {
    return $this->connection->insert_id;
  }
}

?>
