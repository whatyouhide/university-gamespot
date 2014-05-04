<?php
class Model {
  static $db;
  static $table_name;

  // Find a record given a column name. The column name is assumed to be unique,
  // so the first record is returned (or null if no records were found).
  public static function find_unique($table_name, $attr, $val) {
    $q = "SELECT * FROM `" . $table_name .  "` WHERE `$attr` = '$val'";
    $result = self::$db->get_rows($q);

    // Return null or the first match.
    if (empty($result)) {
      return null;
    } else {
      return $result[0];
    }
  }

  // Find all the records in a given table where `$attr` is equal to `$val`.
  public static function find_in_table_by_attribute($table_name, $attr, $val) {
    $q = "SELECT * FROM `" . $table_name .  "` WHERE `$attr` = '$val'";
    return self::$db->get_rows($q);
  }

  // Create a new record in the `$table_name` table of the db.
  // `$attributes` is a key=>value array with column names as keys and values as
  // values.
  // This is meant to be overridden by child classes in order to remove the need
  // for a `$table_name` argument.
  public static function create_record($tbl_name, $attributes) {
    $attrs_names = self::implode_array_keys($attributes);
    $attrs_values = self::implode_array_values($attributes);
    $tbl_name = "`$tbl_name`";

    // Build the query and issue it against the db.
    $q = "INSERT INTO $tbl_name($attrs_names) VALUES ($attrs_values)";
    self::$db->query($q);
  }


  // Private helper methods

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
