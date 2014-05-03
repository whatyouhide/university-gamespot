<?php
// Redirect to a page in the site, relative to SITE_ROOT.
// For example, to redirect to 'SITE_ROOT/games', just redirect('/games').
function redirect($location) {
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
?>
