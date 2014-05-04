<?php
class User extends Model {
  // Find a user by an attribute (which is assumed to be unique throughout the
  // db). Return the found user or null if no users were found.
  public static function find($attr, $val) {
    return parent::find_unique(self::$table_name, $attr, $val);
  }

  // Return all the users where `$attr` is `$val`.
  public static function where_attribute_is($attr, $val) {
    return parent::find_in_table_by_attribute(self::$table_name, $attr, $val);
  }

  // Create a new user with the given `$attributes`.
  public static function create($attributes) {
    parent::create_record(self::$table_name, $attributes);
  }
}

// Initialize some class static attributes.
User::$db = new DB();
User::$table_name = 'users';
?>
