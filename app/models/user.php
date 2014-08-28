<?php
/**
 * This file contains the definition of the User class.
 */

namespace Models;

use Db;

/**
 * A user of the website.
 */
class User extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'users';

  const CONFIRMATION_TOKEN_LENGTH = 32;
  const RESET_TOKEN_LENGTH = 32;
  const RANDOM_PASSWORD_LENGTH = 32;

  /**
   * {@inheritdoc}
   * Also fetch the profile picture and group of this user.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->profile_picture = $this->associated_profile_picture();
    $this->group = $this->associated_group();
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
   * Return true if a user belongs to a group which has a given $permission,
   * false otherwise. Return false also when the user doesn't belong to any
   * group.
   * Example usage:
   * <code>
   * $user->can('manage_blog')
   * </code>
   * @param string $permission The permission to search for.
   * @return bool
   */
  public function can($permission) {
    if (!$this->group) { return false; }

    $attr = "can_$permission";
    return $this->group->$attr;
  }

  /**
   * Return true if the user is an admin of the website, false otherwise.
   * @return bool
   */
  public function is_admin() {
    if (!$this->group) { return false; }
    return $this->group->is_admin;
  }

  /**
   * Return true if the user can see the backend of the website, false
   * otherwise.
   * @return bool
   */
  public function can_access_backend() {
    return !is_null($this->group);
  }

  /**
   * Return true if this is a regular user of the website (non admin-like).
   * @return bool
   */
  public function is_regular() {
    return !$this->can_access_backend();
  }

  /**
   * Return true if the user is blocked.
   * @return bool
   */
  public function is_blocked() {
    return $this->blocked == '1';
  }

  /**
   * Return true if the user has confirmed her email address.
   * @return bool
   */
  public function is_confirmed() {
    return $this->confirmed == '1';
  }

  /**
   * Return the full name of a user (first name + last name).
   * @return string
   */
  public function full_name() {
    return ($this->first_name . ' ' . $this->last_name);
  }

  /**
   * Return true if the user is resetting her password.
   * @return bool
   */
  public function is_resetting() {
    return $this->resetting == '1';
  }

  /**
   * Start the recovering process for this user. This function sets the
   * 'recovering' attribute of this user to true and generates a new recovery
   * token.
   */
  public function start_reset_process() {
    $this->update([
      'resetting' => true,
      'reset_token' => self::new_reset_token()
    ]);
  }

  /**
   * Finish the reset process by resetting the 'reset_token' to null and setting
   * the 'resetting' attribute to false.
   */
  public function finish_reset_process() {
    $this->update([
      'resetting' => false,
      'reset_token' => null
    ]);
  }

  /**
   * {@inheritdoc}
   * This function also hashes the 'password' attribute before passing it to the
   * 'create' parent's mathod.
   * If no confirmation token is found in $attrs, the user is assumed to be
   * confirmed.
   */
  public static function create($attrs, $validate = true) {
    if (!isset($attrs['confirmation_token'])) {
      $attrs['confirmed'] = true;
    }

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
   * Return a valid random confirmation token.
   * @return string
   */
  public static function new_confirmation_token() {
    return random_string(self::CONFIRMATION_TOKEN_LENGTH);
  }

  /**
   * Return a valid recovery token.
   * @return string
   */
  public static function new_reset_token() {
    return random_string(self::RESET_TOKEN_LENGTH);
  }

  /**
   * Return a random password.
   * @return string
   */
  public static function random_password() {
    return random_string(self::RANDOM_PASSWORD_LENGTH);
  }

  /**
   * Return all the regular users on the website.
   * @return array
   */
  public static function regular() {
    return self::where(['group_id' => null]);
  }

  /**
   * Return all the 'backend' users (staff members) of the website except for
   * the one identified by $id (which usually is the current user).
   * @param string|int $id
   * @return array
   */
  public static function staff_members_except($id) {
    $t = static::$table_name;
    $id = Db::escape($id);

    $q = "SELECT * FROM `$t` WHERE"
      . " `group_id` IS NOT NULL"
      . " AND `id` <> '$id'";

    return self::new_instances_from_query($q);
  }

  /**
   * {@inheritdoc}
   */
  protected static function validate($attrs) {
    $validator = new Validator($attrs);

    $validator->must_not_be_empty('first_name', "First name can't be blank");
    $validator->must_not_be_empty('last_name', "Last name can't be blank");
    $validator->must_not_be_empty('hashed_password', "Password can't be blank");
    $validator->must_be_valid_email('email');
    return $validator->error_messages();
  }

  /**
   * Fetch the profile picture associated with this user.
   * @return Upload The profile picture associated with this user.
   */
  private function associated_profile_picture() {
    return Upload::find_by_attribute('user_profile_picture_id', $this->id);
  }

  /**
   * Fetch the group this user is a member of.
   * @return Group
   */
  private function associated_group() {
    return $this->group_id ? Group::find($this->group_id) : null;
  }

  /**
   * Replace the 'passoword' key with an hashed passowrd.
   * @param array $attrs An array of attributes containing a 'password'
   *        attribute.
   * @return array A new array of attributes without 'password' but with an
   *         updated hashed password in 'hashed_password'.
   */
  private static function with_hashed_password($attrs) {
    if (empty($attrs['password'])) {
      $attrs['hashed_password'] = '';
    } else {
      $attrs['hashed_password'] = self::hash_password($attrs['password']);
    }

    unset($attrs['password']);
    return $attrs;
  }
}
?>
