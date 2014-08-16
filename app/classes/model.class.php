<?php
class Model {
  // Static attributes
  public static $db;
  protected static $table_name;
  protected static $key_column;

  // Instance attributes
  private $attrs;


  public function __construct($attributes) {
    $this->attrs = $attributes;
  }

  public function __get($field) {
    // Bubble up this call if the $field attribute is not in the current
    // record's attributes.
    if (!array_key_exists($field, $this->attrs)) {
      trigger_error("Undefined property $field", E_USER_NOTICE);
    }

    return $this->attrs[$field];
  }

  /**
   * Return all the records for the current model.
   * @return array An array of records.
   */
  public static function all() {
    $t = static::$table_name;
    return self::new_instances_from_query("SELECT * FROM `$t`");
  }

  /**
   * Find a record based on the value of its key column (which is unique).
   * @param string|int $key_attribute The value of the key attribute (usually an
   *        id)
   * @return null|array The searched record if present, otherwise null.
   */
  public static function find($key_attribute) {
    $records = self::where([static::$key_column => $key_attribute]);
    return empty($records) ? null : $records[0];
  }

  /**
   * Find a set of records that match a set of attributes.
   * @static
   * @param array $attributes An array of 'attr_name' => 'attr_value' which will
   *        produce a set of WHERE clauses.
   * @return array A set of matching records
   */
  public static function where($attributes) {
    // Return now if there are no attributes to search on.
    if (count($attributes) == 0) { return self::all(); }

    // Build the query.
    $t = static::$table_name;
    $q = "SELECT * FROM `$t` " . self::build_where_clauses_from($attributes);

    return self::new_instances_from_query($q);
  }

  // Create a new record in the `$table_name` table of the db.
  // `$attributes` is a key=>value array with column names as keys and values as
  // values.
  // This is meant to be overridden by child classes in order to remove the need
  // for a `$table_name` argument.
  public static function create($attributes) {
    $attrs_names = self::to_attribute_names(array_keys($attributes));
    $attrs_values = self::to_attributes_values(array_values($attributes));
    $tbl = static::$table_name;

    // Build the query and issue it against the db.
    $q = "INSERT INTO `$tbl`($attrs_names) VALUES ($attrs_values)";
    self::$db->query($q);
  }

  // Private methods

  /**
   * Given an array, return a new array where every element is a new instance of
   * the calling class build with the attributes that were the element of the
   * argument array.
   * @static
   * @access private
   * @param array $arr An array of sets of attributes
   * @return array An array of instances of the calling class
   */
  private static function new_instances_from_query($query) {
    $results = static::$db->get_rows($query);
    return array_map('self::instantiate', $results);
  }

  /**
   * Given a set of attributes, return an instance of the calling class build
   * with the argument attributes.
   * @static
   * @access private
   * @param array $attributes An array of 'name' => 'val' attributes
   * @return array An array of instances of the calling class
   */
  private static function instantiate($attributes) {
    $calling_class = get_called_class();
    return new $calling_class($attributes);
  }

  /**
   * Return a WHERE clause in the form 'WHERE a1 = v1 AND a2 = v2' from a given
   * set of attributes.
   * @static
   * @access private
   * @param array $attributes An arrau of 'attr' => 'val' attributes
   * @return string A MySQL WHERE clause
   */
  private static function build_where_clauses_from($attributes) {
    $i = 0;
    $number_of_attributes = count($attributes);
    $table_name = static::$table_name;
    $clauses = "WHERE";

    // Add the = clause and an AND if this is not the last iteration, for each
    // attribute.
    foreach ($attributes as $attr => $val) {
      $clauses .= " `$table_name`.`$attr` = '$val'";
      if ($i < $number_of_attributes - 1) { $clauses .= " AND"; }
      $i++;
    }

    return $clauses;
  }

  /**
   * Convert an array of attribute names to a list of `name1`,`name2`... .
   * @static
   * @access private
   * @param array $attrs An array of attribute names
   * @return string A list of comma-separated and quoted attribute names
   */
  private static function to_attribute_names($attrs) {
    return implode(', ', array_map(self::quote_with('`'), $attrs));
  }

  /**
   * Convert an array of attribute names to a list of `value1`,`value2`... .
   * @static
   * @access private
   * @param array $values An array of attribute values
   * @return string A list of comma-separated and quoted attribute values
   */
  private static function to_attributes_values($values) {
    return implode(', ', array_map(self::quote_with("'"), $values));
  }

  /**
   * Return a function that quotes a string with the given char.
   * @static
   * @access private
   * @param string $ch A string (like ' or `), usually a char
   * @return function A function that surrounds a string with the char passed to
   *         this function.
   */
  private static function quote_with($ch) {
    return function ($str) use ($ch) {
      return $ch . $str . $ch;
    };
  }
}
?>
