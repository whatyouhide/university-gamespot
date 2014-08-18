<?php
// Handle internal server errors first, so that every PHP error is presented as
// a 500 error.
function error_handler() {
  // An array of errors which need to be handled with a 500 Internal Server
  // Error.
  $fatalErrors = array(
    E_ERROR,
    E_PARSE,
    E_CORE_ERROR,
    E_COMPILE_ERROR,
    E_USER_ERROR
  );

  // Render a 500 Internal Server Error page if the last error type is a fatal
  // one.
  $error = error_get_last();
  if ($error && in_array($error['type'], $fatalErrors)) {
    (new Controller)->render_error(500);
  }
}
register_shutdown_function('error_handler');

// Include the necessary setup for the application.
include 'setup/defines.php';
include 'setup/includes.php';

// Make $_SESSION available and initialize it.
session_start();
Session::init();

// Connect to the database.
Db::init();

// Retrieve the controller and the action (default to index) from $_GET, which
// is itself set by .htaccess.
// The controller name and the action have the form:
//   some_controller/some_action      # the action is 'some_action'
//   some_controller/                 # defaults to the 'index' action
$controllerName = empty($_GET['controller']) ? 'application' : $_GET['controller'];
$action = empty($_GET['action']) ? 'index' : $_GET['action'];


// Convert the `$controllerName` into an actual class name. Practically,
// remove underscores and make it CamelCase, then add the 'Controller' word at
// the end.
$controllerClass = str_replace('_', ' ', $controllerName);
$controllerClass = ucwords($controllerClass);
$controllerClass = str_replace(' ', '', $controllerClass);
$controllerClass = $controllerClass . 'Controller';


// Create the controller and call the provided action on it.
$controller = new $controllerClass;
$controller->$action();
?>
