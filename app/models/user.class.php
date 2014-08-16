<?php
class User extends Model {
  public static $table_name = 'users';
  public static $key_column = 'email';

  // Create a new user with the given `$attributes`.
  public static function create($attrs) {
    $attrs['hashed_password'] = self::hash_password($attrs['password']);
    unset($attrs['password']);
    return parent::create($attrs);
  }

  /**
   * Hash a password using the MD5 algorithm.
   * @param string $password The password to hash
   * @return string A hashed version of the password argument
   */
  public static function hash_password($password) {
    return md5($password);
  }
}

// Initialize some class static attributes.
User::$db = new DB();
?>
