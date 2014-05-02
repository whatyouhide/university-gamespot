<?php
// Redirect to a page in the site, relative to SITE_ROOT.
// For example, to redirect to 'SITE_ROOT/games', just redirect('/games').
function redirect($location) {
  header("Location: " . SITE_ROOT . $location);
  die();
}
?>
