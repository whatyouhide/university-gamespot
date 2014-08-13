<?php
// Redirect to a page in the site, relative to SITE_ROOT.
// For example, to redirect to 'SITE_ROOT/games', just redirect('/games').
function redirect($location, $flash_messages = array(), $data = null) {
  // Append the data to the url (if present).
  if ($data) $location .= '?' . http_build_query($data);

  // Store flash messages in the session.
  foreach ($flash_messages as $type => $msg) {
    $_SESSION['flash'][$type] = $msg;
  }

  // Actual redirect.
  header("Location: " . SITE_ROOT . $location);
  die();
}


// Detect the type of the current request.
function request_type() {
  return $_SERVER['REQUEST_METHOD'];
}

// Some helper functions which detect various types of requests.
function is_get_request() {
  return request_type() == 'GET';
}
function is_post_request() {
  return request_type() == 'POST';
}

// Check if a user is currently signed in.
function is_signed_in() {
  return $_SESSION['user'];
}

// Create a MySQL friendly timestamp of the current time.
function mysql_timestamp() {
  return date('Y-m-d H:i:s', time());
}
?>
