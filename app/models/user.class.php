<?php
class User extends Model {
  public static $table_name = 'users';
  public static $key_column = 'email';

  /**
   * Update the user's password.
   * @param string $new_pass The new password (still non hashed)
   */
  public function update_password($new_pass) {
    $this->update(['hashed_password' => self::hash_password($new_pass)]);
  }

  /**
   * {@inheritdoc}
   * This function also hashes the 'password' attribute before passing it to the
   * 'create' parent's mathod.
   */
  public static function create($attrs) {
    return parent::create(self::with_hashed_password($attrs));
  }

  /**
   * Hash a password using the MD5 algorithm.
   * @param string $password The password to hash
   * @return string A hashed version of the password argument
   */
  public static function hash_password($password) {
    return md5($password);
  }

  /**
   * Replace the 'passoword' key with an hashed passowrd.
   * @param array $attrs An array of attributes containing a 'password'
   *        attribute.
   * @return array A new array of attributes without 'password' but with an
   *         updated hashed password in 'hashed_password'.
   */
  private static function with_hashed_password($attrs) {
    $attrs['hashed_password'] = self::hash_password($attrs['password']);
    unset($attrs['password']);
    return $attrs;
  }
}

User::$db = new DB();
?>
