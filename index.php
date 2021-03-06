<?php
/**
 * The root of the application.
 */

// Report all errors in development.
if (!isset($_ENV['GAMESPOT_PRODUCTION']) || empty($_ENV['GAMESPOT_PRODUCTION'])) {
  error_reporting(E_ALL);
}

// Parse the configuration file (with true as a second argument, the .ini file
// gets parsed with section-awareness) as the first thing in order to have
// $GLOBALS['config'] set everywhere.
$GLOBALS['config'] = parse_ini_file('config.ini', true);

// Include the necessary setup for the application.
include 'setup/shutdown_function.php';
include 'setup/defines.php';
include 'setup/includes.php';

// Make $_SESSION available and initialize it.
session_start();
Common\Session::init();

// Connect to the database.
Common\Db::init();

// Handle the parameters that Apache passed here (let them default to '') and
// remove them from the $_GET array in order to have a clean slate when
// starting.
$params = Http\Request::controller_action_backend();

// Dispatch an action to a controller.
Common\Router::dispatch_action_to_controller(
  $params['controller'],
  $params['action'],
  $params['backend']
);
?>
