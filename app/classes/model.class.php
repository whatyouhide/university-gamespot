<?php
/**
 * This file contains the definition of the Model class.
 */

namespace Models;

use Common\Db;
use Validator;

/**
 * The base model class which all models inherit from.
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

    // Sanitize the attributes.
    $sanitized = self::sanitize_attributes($attributes);

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
    foreach ($sanitized as $attr => $val) {
      $q .= " `$t`.`$attr` = " . (is_null($val) ? "NULL" : "'$val'");
      // If it's not the last iteration, append a comma.
      if ($i < count($sanitized) - 1) $q .= ', ';
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

    $sanitized = self::sanitize_attributes($attributes);

    // Build the query.
    $t = static::$table_name;
    $q = "SELECT * FROM `$t` " . self::build_where_clauses_from($sanitized);

    return self::new_instances_from_query($q);
  }

  /**
   * Find a set of records by their ids.
   * @param array $ids
   * @return array
   */
  public static function find_multiple($ids) {
    $t = static::$table_name;
    $ids = '(' . implode(', ', $ids) . ')';
    $q = "SELECT * FROM `$t` WHERE `id` IN $ids";
    return static::new_instances_from_query($q);
  }

  /**
   * Return the number of records that are in the db for the calling model.
   * @return int
   */
  public static function count() {
    $t = static::$table_name;
    $q = "SELECT COUNT(*) FROM `$t`";
    return intval(Db::get_rows($q)[0]['COUNT(*)']);
  }

  /**
   * Return the latest record based on the value of $attribute.
   * @param string $attribute
   * @param int $limit How many records to fetch, defaults to one.
   * @return mixed
   */
  public static function latest_by_attribute($attribute, $limit = 1) {
    $t = static::$table_name;
    $q = "SELECT * FROM `$t` ORDER BY `$attribute` DESC LIMIT $limit";

    $results = static::new_instances_from_query($q);
    return ($limit == 1) ? $results[0] : $results;
  }


  /**
   * Create a new instance of the calling model and save it to the db.
   * @param array $attributes An array of 'name' => 'value' attributes.
   * @param bool $validate If false, don't validate the record.
   * @return mixed The record just inserted in the db.
   */
  public static function create($attributes, $validate = true) {
    $t = static::$table_name;

    $sanitized = self::sanitize_attributes($attributes);
    $attrs_names = self::to_attribute_names(array_keys($sanitized));
    $attrs_values = self::to_attributes_values(array_values($sanitized));

    if ($validate) {
      $errors = static::validate($attributes);
      if (!empty($errors)) {
        return new InvalidRecord($errors);
      }
    }

    // Build the query and issue it against the db.
    $q = "INSERT INTO `$t`($attrs_names) VALUES ($attrs_values)";
    Db::query($q);

    // Return the newly inserted record.
    return self::find(Db::last_insert_id());
  }

  /**
   * Return an array of ['id' => $property] couples which is a <select>-friendly
   * way to use models. This returns all the models.
   * @param string $property The value associated with a record id.
   * @param bool $with_empty If true, prepend an empty ('' => '') element to the
   * array.
   * @return array
   */
  public static function all_for_select_with($property, $with_empty = false) {
    $all = static::all();

    $result = array_combine(array_pluck($all, 'id'), array_pluck($all, 'name'));

    if ($with_empty) {
      return ['' => ''] + $result;
    } else {
      return $result;
    }
  }

  /**
   * Perform validations on a set of attributes. Return an array of errors for
   * those attributes (an empty array if no errors are found).
   * @param array $attributes An associative array of 'attr' => 'val' couples.
   * @return array
   */
  protected static function validate($attributes) {
    return array();
  }

  /**
   * Given a query, return a new array where every element is an object
   * instantiated from the ones returned by the query.
   * @param string $query An array of sets of attributes.
   * @return array An array of instances of the calling class.
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
    $model = 'Models\\' . $model;
    return empty($records) ? null : (new $model($records[0]));
  }

  /**
   * Sanitize all the values in an array of attributes.
   * @param array $attributes An associative array of attribtues.
   * @return array A copy of the original array, but with sanitized values.
   */
  protected static function sanitize_attributes($attributes) {
    return array_map('self::sanitize_value', $attributes);
  }

  /**
   * Build a WHERE clause from an array of single clauses.
   *
   * The WHERE clause will be in the form `WHERE a AND b AND c`. The members of
   * the `$conditions` array will be statements like `price > '13'` and so on.
   * This is on a lower level than `Model::build_where_clauses_from()`, which
   * builds a where clause starting with an associative array of attributes.
   *
   * @param array $conditions
   * @return string
   */
  protected static function where_clause_from_conditions($conditions) {
    if (empty($conditions)) {
      return '';
    } else {
      return 'WHERE ' . implode(' AND ', $conditions);
    }
  }

  /**
   * Sanitize a single value for inserting it into the database.
   * If the attribute is a string, escape it; if it's null, leave it null; etc.
   * @param mixed $val
   * @return mixed
   */
  private static function sanitize_value($val) {
    return is_null($val) ? null : Db::escape($val);
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
