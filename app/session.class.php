<?php
class Session {
  // Store a user in the 'user' session key.
  public static function store_user($user) {
    $_SESSION['user'] = $user;
  }

  // Add/set a flash message.
  public static function flash($type, $msg) {
    $_SESSION['flash'][$type] = $msg;
  }
}
?>
