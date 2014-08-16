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
      user_error("Undefined property $field in __get");
    }

    return $this->attrs[$field];
  }

  /**
   * @todo I should define a static variable which holds all the associations so
   * that I can check for existence in the $this->attrs attributes like in
   * `__get`.
   */
  public function __set($field, $value) {
    $this->attrs[$field] = $value;
  }

  /**
   * Reload a record, returning a new instance for that record.
   * @param mixed $key_value The key attribute in order to find the record
   *        again. If $key_value is null, the standard key attribute (already
   *        present on the record) will be used.
   * @return mixed A new instance for the reloaded record.
   */
  public function reload($key_value = null) {
    $calling_class = get_called_class();

    // The attribute will be the standard key if no arguments were passed to
    // this function, otherwise the argument will be used to find the record
    // again.
    $attribute = ($key_value == null) ? $this->key_value() : $key_value;

    return $calling_class::find($attribute);
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

  /**
   * Create a new instance of the calling model and save it to the db.
   * @param array $attribtutes An array of 'name' => 'value attributes
   * @return mixed The record just inserted in the db
   */
  public static function create($attributes) {
    $attrs_names = self::to_attribute_names(array_keys($attributes));
    $attrs_values = self::to_attributes_values(array_values($attributes));
    $t = static::$table_name;

    // Build the query and issue it against the db.
    $q = "INSERT INTO `$t`($attrs_names) VALUES ($attrs_values)";
    self::$db->query($q);

    // Return the newly inserted record.
    if (static::$key_column == 'id') {
      $last_insert_id = static::$db->last_insert_id();
      return self::find($last_insert_id);
    } else {
      return self::find($attributes[static::$key_column]);
    }
  }

  /**
   * Given an array, return a new array where every element is a new instance of
   * the calling class build with the attributes that were the element of the
   * argument array.
   * @param array $arr An array of sets of attributes
   * @return array An array of instances of the calling class
   */
  public static function new_instances_from_query($query) {
    $results = static::$db->get_rows($query);
    return array_map('self::instantiate', $results);
  }

  /**
   * Update a record with a new set of attributes.
   * @param array $attributes A new set of attributes.
   */
  public function update($attributes) {
    // Return the untouched record if there are no attributes.
    if (empty($attributes)) return $this;

    $t = static::$table_name;
    $key_col = static::$key_column;

    // Build the query.
    $q = "UPDATE `$t` SET";

    $i = 0;
    foreach ($attributes as $attr => $val) {
      $q .= " `$t`.`$attr` = '$val'";

      // If it's not the last iteration, append a comma.
      if ($i < count($attributes) - 1) $q .= ', ';

      $i++;
    }

    $q .= " WHERE `$t`.`$key_col` = '{$this->key_value()}'";

    static::$db->query($q);
  }

  /**
   * Return the value of the key attribute for this instance.
   * @return mixed The value of the key attribute.
   */
  private function key_value() {
    $key_col = static::$key_column;
    return $this->$key_col;
  }

  /**
   * Given a set of attributes, return an instance of the calling class build
   * with the argument attributes.
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
   * @param array $attrs An array of attribute names
   * @return string A list of comma-separated and quoted attribute names
   */
  private static function to_attribute_names($attrs) {
    return implode(', ', array_map(self::quote_with('`'), $attrs));
  }

  /**
   * Convert an array of attribute names to a list of `value1`,`value2`... .
   * @param array $values An array of attribute values
   * @return string A list of comma-separated and quoted attribute values
   */
  private static function to_attributes_values($values) {
    return implode(', ', array_map(self::quote_with("'"), $values));
  }

  /**
   * Return a function that quotes a string with the given char.
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
