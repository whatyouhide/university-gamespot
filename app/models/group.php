<?php
/**
 * This file contains the definition of the Group class.
 */

/**
 * A group of users.
 * @package Gamespot
 * @subpackage Models
 */
class Group extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'groups';

  /**
   * {@inheritdoc}
   * Also convert all the attributes that start with 'can_' or 'is_' to boolean
   * values.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->convert_to_boolean_attributes();
  }

  /**
   * Return an array of groups that have a given $permission.
   * @param string $permission
   * @return array
   */
  public static function with_permission($permission) {
    return self::where(["can_$permission" => '1']);
  }

  /**
   * Convert all the attributes that start with 'can_' or 'is_' to boolean
   * values; these attributes are returned as strings ('1' or '0') by MySQL
   * (they're TINYINTs).
   */
  private function convert_to_boolean_attributes() {
    foreach ($this->attributes() as $attr => $val) {
      if (preg_match('/^can_/', $attr) || preg_match('/^is_/', $attr)) {
        $this->$attr = ($val == '1');
      }
    }
  }
}
?>
