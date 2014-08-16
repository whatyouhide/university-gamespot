<?php
class Session {
  /**
   * Return the currently logged in user or null if there's no user logged in.
   * @return null|User The currently logged in user or null if there's none
   */
  public static function user() {
    return $_SESSION['user'];
  }

  /**
   * Stores a user in the session.
   * @param User $user The user to store in the session
   * @return User The user which has just been stored in the session
   */
  public static function store_user($user) {
    $_SESSION['user'] = $user;
    return $user;
  }

  /**
   * Sign out the current user by removing it from the session.
   */
  public static function sign_out_user() {
    unset($_SESSION['user']);
  }

  /**
   * Add a flash message to the current session. This message will be displayed
   * in the next request.
   * @param string $type The type of the flash message (notice, error etc.)
   * @param string $message The message to set
   */
  public static function flash($type, $msg) {
    $_SESSION['flash'][$type] = $msg;
  }

  /**
   * Return the flash array contained in the session.
   * @return array The flash array
   */
  public static function current_flash() {
    return $_SESSION['flash'];
  }

  /**
   * Empty out the flash array.
   */
  public static function empty_flash() {
    $_SESSION['flash'] = array();
  }
}
?>
