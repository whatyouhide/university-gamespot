<?php
// Define some constants.
define('SITE_NAME', 'gamespot');
define('SITE_ROOT', '/' . SITE_NAME);
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/' . SITE_NAME);

// Make $_SESSION available.
session_start();

// Include some classes that will be used practically everywhere.
include ROOT . '/app/gamespot-smarty.class.php';
include ROOT . '/app/db.class.php';
?>
