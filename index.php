<?php
include 'app/setup.php';

// Retrieve the controller and the action (default to index.php) from $_GET.
$controller = empty($_GET['controller']) ? 'main' : $_GET['controller'];
$action = empty($_GET['action']) ? 'index.php' : $_GET['action'];

// Include the appropriate controller.
include 'app/controllers/' . $controller . '/' . $action;
?>
