<?php
class Model {
  public static $db;
  protected static $table_name;
  protected static $key_column;

  /**
   * Return all the records for the current model.
   * @return array An array of records.
   */
  public static function all() {
    $t = static::$table_name;
    return static::$db->get_rows("SELECT * FROM `$t`");
  }

  /**
   * Find a record based on the value of its key column (which is unique).
   * @param string|int $key_attribute The value of the key attribute (usually an
   *        id)
   * @return null|array The searched record if present, otherwise null.
   */
  public static function find($key_attribute) {
    $records = self::where([static::$key_column => $key_attribute]);

    if (empty($records)) {
      return null;
    } else {
      return $records[0];
    }
  }

  /**
   * Find a set of records that match a set of attributes.
   * @param array $attributes An array of 'attr_name' => 'attr_value' which will
   *        produce a set of WHERE clauses.
   * @return array A set of matching records
   */
  public static function where($attributes) {
    $number_of_attributes = count($attributes);

    // Return now if there are no attributes to search on.
    if ($number_of_attributes == 0) { return self::all(); }

    // Build the query.
    $t = static::$table_name;
    $query = "SELECT * FROM `$t` WHERE";

    $i = 0;
    foreach ($attributes as $attr => $val) {
      $query .= " `$t`.`$attr` = '$val'";
      // Append AND if this is not the last element.
      if ($i < $number_of_attributes - 1) { $query .= " AND"; }
      $i++;
    }

    return static::$db->get_rows($query);
  }

  // Create a new record in the `$table_name` table of the db.
  // `$attributes` is a key=>value array with column names as keys and values as
  // values.
  // This is meant to be overridden by child classes in order to remove the need
  // for a `$table_name` argument.
  public static function create($attributes) {
    $attrs_names = self::implode_array_keys($attributes);
    $attrs_values = self::implode_array_values($attributes);
    $tbl = static::$table_name;

    // Build the query and issue it against the db.
    $q = "INSERT INTO `$tbl`($attrs_names) VALUES ($attrs_values)";
    self::$db->query($q);
  }

  public static function create_record($attributes) {
    self::create($attributes);
  }


  // Private methods

  // Given an array of key => value pairs, return a string with all the keys
  // quoted with a ` and separated by a comma.
  // This is useful in order to compose SQL queries.
  private static function implode_array_keys($array) {
    $quote = function ($el) { return '`' . $el . '`'; };

    $keys = array_keys($array);

    $keys = array_map($quote, $keys);
    return implode(', ', $keys);
  }


  private static function implode_array_values($array) {
    $quote = function ($el) { return "'" . $el . "'"; };

    $values = array_values($array);

    $values = array_map($quote, $values);
    return implode(', ', $values);
  }
}
?>
