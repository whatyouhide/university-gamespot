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
include ROOT . '/app/model.class.php';
include ROOT . '/app/controller.class.php';


// Include some utility functions.
include ROOT . '/app/functions.php';


// Include all the models and the controllers.
$files_to_include = array_merge(
  glob(ROOT . '/app/models/*'),
  glob(ROOT . '/app/controllers/*')
);
foreach ($files_to_include as $filename) {
  include $filename;
}
?>
