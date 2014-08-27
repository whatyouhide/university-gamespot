<?php
/**
 * The root of the application.
 */

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

// Connect to the database.
Db::init();

// Handle the parameters that Apache passed here (let them default to '') and
// remove them from the $_GET array in order to have a clean slate when
// starting.
$params = array();
foreach(array('controller', 'action', 'backend') as $el) {
  $params[$el] = isset($_GET[$el]) ? $_GET[$el] : '';
  unset($_GET[$el]);
}

// Dispatch an action to a controller.
Router::dispatch_action_to_controller(
  $params['controller'],
  $params['action'],
  $params['backend']
);
?>
