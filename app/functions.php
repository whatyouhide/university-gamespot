<?php
// Redirect to a page in the site, relative to SITE_ROOT.
// For example, to redirect to 'SITE_ROOT/games', just redirect('/games').
function redirect($location, $flash_messages = array(), $data = null) {
  // Append the data to the url (if present).
  if ($data) { $location .= '?' . http_build_query($data); }

  // Store flash messages in the session.
  foreach ($flash_messages as $type => $msg) {
    $_SESSION['flash'][$type] = $msg;
  }

  // Actual redirect.
  header("Location: " . SITE_ROOT . $location);
  die();
}

// Create a MySQL friendly timestamp of the current time.
function mysql_timestamp() {
  return date('Y-m-d H:i:s', time());
}

// Print an object surrounded by a <pre> tag.
function echo_debug($obj) {
  echo '<pre>';
  print_r($obj);
  echo '</pre>';
}

// Return a function that surrounds a string with another string.
function surround_with($surrounder) {
  return function ($str) use ($surrounder) {
    return $surrounder . $str . $surrounder;
  };
}
?>
