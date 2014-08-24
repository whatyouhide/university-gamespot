<?php
/**
 * This file contains the definition of the Model class.
 */

/**
 * The base model class which all models inherit from.
 * @package Gamespot
 * @subpackage Models
 */
class Model {
  /**
   * @var array An array of attributes for the current instance.
   */
  private $attrs;

  /**
   * @var array An array of validation errors.
   */
  protected $errors;

  /**
   * @var string The table name of the current model.
   * @abstract
   */
  protected static $table_name;

  /**
   * Create an instance of the calling model based on a set of attributes.
   * Also call the `validate` method on the newly created record.
   * @param array $attributes An array of attributes.
   */
  public function __construct($attributes) {
    $this->attrs = $attributes;
    $this->errors = array();
  }

  /**
   * Get an attribute of this instance without accessing the internal attribute
   * representation.
   * @param string $field The attribute to retrieve.
   * @return mixed The value of the attribute if present, otherwise an error.
   */
  public function __get($field) {
    if (array_key_exists($field, $this->attrs)) {
      return $this->attrs[$field];
    } else {
      user_error("Undefined property $field in __get");
    }
  }

  /**
   * Set an attribute of this instance without accessing the internal attribute
   * representation.
   * @param string $field The attribute to set.
   * @param mixed $value The new value for that attribute.
   *
   * @todo I should define a static variable which holds all the associations so
   * that I can check for existence in the $this->attrs attributes like in
   * `__get`.
   */
  public function __set($field, $value) {
    $this->attrs[$field] = $value;
  }

  /**
   * This instance's attributes.
   * @return array An array of 'attr' => 'val' attributes.
   */
  public function attributes() {
    return $this->attrs;
  }

  /**
   * Reload a record modifying the original one.
   * @return mixed The modified instance.
   */
  public function reload() {
    $calling_class = get_called_class();
    $new_record = $calling_class::find($this->id);

    foreach ($new_record->attributes() as $attr => $new_val) {
      $this->$attr = $new_val;
    }

    return $this;
  }

  /**
   * Remove the current record from the database.
   */
  public function destroy() {
    $t = static::$table_name;
    Db::query("DELETE FROM `$t` WHERE `id` = '{$this->id}'");

    // Unset the attributes of this PHP object.
    foreach ($this->attrs as $attr => $val) {
      unset($this->attrs[$attr]);
    }
  }

  /**
   * Update a record with a new set of attributes.
   * @param array $attributes A new set of attributes.
   * @return mixed The updated record.
   */
  public function update($attributes) {
    // Return the untouched record if there are no attributes.
    if (empty($attributes)) return $this;

    // If there are validation errors, set them on the current record and return
    // the unmodified record.
    $errors = static::validate($attributes);
    if (!empty($errors)) {
      $this->errors = $errors;
      return $this;
    }

    $t = static::$table_name;

    // Build the query.
    $q = "UPDATE `$t` SET";

    $i = 0;
    foreach ($attributes as $attr => $val) {
      $q .= " `$t`.`$attr` = " . (is_null($val) ? "NULL" : "'$val'");
      // If it's not the last iteration, append a comma.
      if ($i < count($attributes) - 1) $q .= ', ';
      $i++;
    }

    $q .= " WHERE `$t`.`id` = '{$this->id}'";

    Db::query($q);

    return $this->reload();
  }

  /**
   * Return true if the record is valid (no validation errors are present).
   * @return bool
   */
  public function is_valid() {
    return empty($this->errors);
  }

  /**
   * Return a list of error messages for this record.
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

  /**
   * Return all the records for the current model.
   * @return array
   */
  public static function all() {
    $t = static::$table_name;
    return self::new_instances_from_query("SELECT * FROM `$t`");
  }

  /**
   * Find a record by its id.
   * @param integer|string $id The id of the record to be found.
   * @return null|mixed The found record if present, otherwise null.
   */
  public static function find($id) {
    $instances = self::where(['id' => $id]);
    return empty($instances) ? null : $instances[0];
  }

  /**
   * Find a record by a specific attribute.
   * @param string $attr_name The name of the attribute.
   * @param mixed $value The value of the attribute.
   * @return null|mixed The found record or null.
   */
  public static function find_by_attribute($attr_name, $value) {
    $instances = self::where([$attr_name => $value]);
    return empty($instances) ? null : $instances[0];
  }

  /**
   * Find a set of records that match a set of attributes.
   * @param array $attributes An array of 'attr_name' => 'attr_value' which will
   *        produce a set of WHERE clauses.
   * @return array A set of matching records
   */
  public static function where($attributes) {
    // Return now if there are no attributes to search on.
    if (empty($attributes)) { return self::all(); }

    // Build the query.
    $t = static::$table_name;
    $q = "SELECT * FROM `$t` " . self::build_where_clauses_from($attributes);

    return self::new_instances_from_query($q);
  }

  /**
   * Create a new instance of the calling model and save it to the db.
   * @param array $attribtutes An array of 'name' => 'value' attributes.
   * @return mixed The record just inserted in the db.
   */
  public static function create($attributes) {
    $attrs_names = self::to_attribute_names(array_keys($attributes));
    $attrs_values = self::to_attributes_values(array_values($attributes));
    $t = static::$table_name;

    $errors = static::validate($attributes);
    if (!empty($errors)) {
      return new InvalidRecord($errors);
    }

    // Build the query and issue it against the db.
    $q = "INSERT INTO `$t`($attrs_names) VALUES ($attrs_values)";
    Db::query($q);

    // Return the newly inserted record.
    return self::find(Db::last_insert_id());
  }

  /**
   * Perform validations on a set of attributes. Return an array of errors for
   * those attributes (an empty array if no errors are found).
   * @abstract
   * @param array $attributes An associative array of 'attr' => 'val' couples.
   * @return array
   */
  protected static function validate($attributes) {
    return array();
  }

  /**
   * Given an array, return a new array where every element is a new instance of
   * the calling class build with the attributes that were the element of the
   * argument array.
   * @param array $arr An array of sets of attributes
   * @return array An array of instances of the calling class
   */
  protected static function new_instances_from_query($query) {
    $results = Db::get_rows($query);
    return array_map('self::instantiate', $results);
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
   * Return a new instance of a model retrieved from the given query.
   * @param string $model The name of the model you want to instantiate.
   * @param string $query The query to retrieve the target record.
   * @return mixed A new instance of `$model`.
   */
  protected static function instantiate_model_from_query($model, $query) {
    $records = Db::get_rows($query);
    return empty($records) ? null : (new $model($records[0]));
  }

  /**
   * Return a WHERE clause in the form 'WHERE a1 = v1 AND a2 = v2' from a given
   * set of attributes.
   * @param array $attributes An array of 'attr' => 'val' attributes
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
      $clauses .= ' ' . self::build_single_where_clause($attr, $val);
      if ($i < $number_of_attributes - 1) { $clauses .= " AND"; }
      $i++;
    }

    return $clauses;
  }

  /**
   * Build a single WHERE clause (the 'attr = val' part) given an attribute name
   * and a value.
   * @param string $attr The attribute name.
   * @param mixed $val The attribute value.
   * @return string
   */
  private static function build_single_where_clause($attr, $val) {
    $t = static::$table_name;

    // If $val is exactly `true` or `false`, convert it to '1' or '0'.
    if ($val === true) {
      $val = '1';
    } else if ($val === false) {
      $val = '0';
    }

    $clause = "`$t`.`$attr` ";
    $clause .= is_null($val) ? "IS NULL" : "= '$val'";

    return $clause;
  }

  /**
   * Convert an array of attribute names to a list of `name1`,`name2`... .
   * @param array $attrs An array of attribute names
   * @return string A list of comma-separated and quoted attribute names
   */
  private static function to_attribute_names($attrs) {
    return implode(', ', array_map(surround_with('`'), $attrs));
  }

  /**
   * Convert an array of attribute names to a list of `value1`,`value2`... .
   * @param array $values An array of attribute values
   * @return string A list of comma-separated and quoted attribute values
   */
  private static function to_attributes_values($values) {
    return implode(', ', array_map(surround_with("'"), $values));
  }
}
?>
