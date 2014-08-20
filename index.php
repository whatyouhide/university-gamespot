<?php
// Include the necessary setup for the application.
include 'setup/shutdown_function.php';
include 'setup/defines.php';
include 'setup/includes.php';

// Make $_SESSION available and initialize it.
session_start();

// Connect to the database.
Db::init();

// Dispatch an action to a controller.
Router::dispatch_action_to_controller(
  $_GET['controller'],
  $_GET['action'],
  $_GET['backend']
);
?>
