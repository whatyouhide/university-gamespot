<?php
class Session {
  // Store a user in the 'user' session key.
  public static function user($user = null) {
    if ($user) {
      $_SESSION['user'] = $user;
    }

    return $_SESSION['user'];
  }

  // Add/set a flash message.
  public static function flash($type, $msg) {
    $_SESSION['flash'][$type] = $msg;
  }
}
?>
