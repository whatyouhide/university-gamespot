<?php
// Include the necessary setup for the application.
include 'app/setup.php';


// Retrieve the controller and the action (default to index) from $_GET, which
// is itself set by .htaccess.
// The controller name and the action have the form:
//   some_controller/some_action      # the action is 'some_action'
//   some_controller/                 # defaults to the 'index' action
$controller_name = empty($_GET['controller']) ? 'application' : $_GET['controller'];
$action = empty($_GET['action']) ? 'index' : $_GET['action'];


// Convert the `$controller_name` into an actual class name. Practically,
// remove underscores and make it CamelCase, then add the 'Controller' word at
// the end.
$controller_class = str_replace('_', ' ', $controller_name);
$controller_class = ucwords($controller_class);
$controller_class = str_replace(' ', '', $controller_class);
$controller_class = $controller_class . 'Controller';


// Create the controller and call the provided action on it.
$controller = new $controller_class;
$controller->$action();
?>
