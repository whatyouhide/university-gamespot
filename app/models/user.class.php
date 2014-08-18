<?php
class User extends Model {
  public static $table_name = 'users';

  /**
   * {@inheritdoc}
   * Also fetch the profile picture of this user.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->profile_picture = $this->associated_profile_picture();
  }

  /**
   * Update the user's password.
   * @param string $new_pass The new password (still non hashed)
   */
  public function update_password($new_pass) {
    $this->update(['hashed_password' => self::hash_password($new_pass)]);
  }

  /**
   * Set the profile picture of this user to the passed Upload.
   * @param Upload $upload The Upload profile picture.
   */
  public function update_profile_picture($upload) {
    if ($this->profile_picture) {
      $this->profile_picture->destroy();
    }

    $upload->update(['user_profile_picture_id' => $this->id]);
    $this->profile_picture = $upload;
  }

  /**
   * Remove the profile picture of this user (and delete the actual file).
   */
  public function delete_profile_picture() {
    if (!$this->profile_picture) { return; }
    $this->profile_picture->destroy();
    $this->profile_picture = null;
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
   * Fetch the profile picture associated with this user.
   * @return Upload The profile picture associated with this user.
   */
  private function associated_profile_picture() {
    return Upload::find_by_attribute('user_profile_picture_id', $this->id);
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
