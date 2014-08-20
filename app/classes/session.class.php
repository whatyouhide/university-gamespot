<?php
/**
 * An abstraction over the `$_SESSION` object, build in a singleton-style way.
 * @package Gamespot
 * @subpackage Common
 */
class Session {
  /**
   * Return the currently logged in user or null if there's no user logged in.
   * @return null|User The currently logged in user or null if there's none
   */
  public static function user() {
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
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
    if (!isset($_SESSION['flash'])) self::empty_flash();

    $_SESSION['flash'][$type] = $msg;
  }

  /**
   * Append a bunch of flash messages to the current session.
   * @param array $messages
   */
  public static function append_flash_messages($messages) {
    if (!isset($_SESSION['flash'])) self::empty_flash();
    $_SESSION['flash'] = array_merge($_SESSION['flash'], $messages);
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

  /**
   * Get the 'referer' session attribute.
   * If it wasn't set, set it to null first.
   * @return string
   */
  public static function referer() {
    if (!isset($_SESSION['referer'])) {
      self::reset_referer();
    }

    return $_SESSION['referer'];
  }

  /**
   * Set the referer to a given string. The referer will be used to redirect
   * requests after logging a user in.
   * @param string $referer The new value for the referer.
   */
  public static function set_referer_to($referer) {
    $_SESSION['referer'] = $referer;
  }

  /**
   * Reset referer to the default value (`null`).
   */
  public static function reset_referer() {
    $_SESSION['referer'] = null;
  }

  /**
   * Return the referer URL if present, otherwise the `$alternate_url`.
   * After that, reset the referer attribute of the session.
   *
   * Example: in a 'sign in' action, I could have:
   *
   * <code>
   * redirect(Session::referer_and_reset_or_url('/')
   * </code>
   *
   * in order to redirect to the referer if there is one, otherwise to `/`.
   *
   * @param string $alternate_url
   * @return string
   */
  public static function referer_and_reset_or_url($alternate_url) {
    if (self::referer()) {
      $referer = self::referer();
      self::reset_referer();
      return $referer;
    } else {
      return $alternate_url;
    }
  }
}
?>
