<?php
/**
 * This file contains common functions used throughout the application.
 * @package Gamespot
 * @subpackage Common
 * @author Andrea Leopardi <an.leopardi@gmail.com>
 */

/**
 * Redirect to a page in the site, relative to `SITE_ROOT`.
 * Example:
 * <code>
 * <?php redirect('/games'); ?>
 * </code>
 *
 * This function also exits the script after redirecting with a call to `die()`.
 *
 * @param string $location The location to redirect to.
 * @param array $flash_messages An associative array of flash messages.
 * @param $data An associative array of data to be appended to the URL.
 */
function redirect($location, $flash_messages = array(), $data = null) {
  // Append the data to the url (if present).
  if ($data) { $location .= '?' . http_build_query($data); }

  // Store flash messages in the session.
  Session::append_flash_messages($flash_messages);

  // Actual redirect.
  header("Location: " . SITE_ROOT . $location);
  die();
}

/**
 * Print an object surrounded by a `<pre>` tag.
 * @param mixed $obj
 */
function echo_debug($obj) {
  echo '<pre>';
  var_dump($obj);
  echo '</pre>';
}

/**
 * Return a function that surrounds a string with the given `$surrounder`.
 * @param string $surrounder
 * @return function A function which takes a string as an argument and returns
 *         that string surrounded with `$surrounder`.
 */
function surround_with($surrounder) {
  return function ($str) use ($surrounder) {
    return $surrounder . $str . $surrounder;
  };
}

/**
 * Render a 404 Not Found error.
 */
function not_found() {
  (new Controller)->render_error(404);
}

/**
 * Render a 500 Internal Server Error.
 */
function internal_server_error() {
  (new Controller)->render_error(500);
}

/**
 * Build an array which contains the return values of the call to $property on
 * each object of the original array.
 * @param array $array The original array.
 * @param string $property The property to extract from each object.
 * @return array
 */
function array_pluck($array, $property) {
  $f = function ($el) use ($property) { return $el->$property; };
  return array_map($f, $array);
}
?>
