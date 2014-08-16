<?php
class User extends Model {
  public static $table_name = 'users';
  public static $key_column = 'email';

  // Return all the users where `$attr` is `$val`.
  public static function where_attribute_is($attr, $val) {
    return parent::find_in_table_by_attribute($attr, $val);
  }

  // Create a new user with the given `$attributes`.
  public static function create($attrs) {
    $attrs['hashed_password'] = self::hash_password($attrs['password']);
    unset($attrs['password']);
    parent::create($attrs);
  }

  // Hash a password.
  public static function hash_password($password) {
    return md5($password);
  }
}

// Initialize some class static attributes.
User::$db = new DB();
?>
