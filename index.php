<?php
$controller = $_GET['controller'];
$action = empty($_GET['action']) ? 'index.php' : $_GET['action'];

include 'app/controllers/' . $controller . '/' . $action;
?>
