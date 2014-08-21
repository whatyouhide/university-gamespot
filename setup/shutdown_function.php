<?php
/**
 * Handle errors with a 500 Internal Server Error.
 */
function error_handler() {
  $fatal_errors = [
    E_ERROR,
    E_PARSE,
    E_CORE_ERROR,
    E_COMPILE_ERROR,
    E_USER_ERROR
  ];

  $error = error_get_last();

  if ($error && in_array($error['type'], $fatal_errors)) {
    internal_server_error();
  }
}

register_shutdown_function('error_handler');
?>
