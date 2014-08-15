<?php
// Make $_SESSION available.
session_start();

// Define some constants.
define('SITE_NAME', 'gamespot');
define('SITE_ROOT', '/' . SITE_NAME);
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/' . SITE_NAME);

// Augment the include path.
set_include_path(ROOT);

// Include some classes that will be used everywhere in the application.
include 'app/classes/gamespot-smarty.class.php';
include 'app/classes/db.class.php';
include 'app/classes/model.class.php';
include 'app/classes/controller.class.php';
include 'app/classes/session.class.php';
include 'app/classes/request.class.php';
include 'app/classes/mailer.class.php';

// Include some utility functions.
include 'app/functions.php';

// Include all the models and the controllers.
// Also include all the Smarty helpers.
$files_to_include = array_merge(
  glob(ROOT . '/app/models/*'),
  glob(ROOT . '/app/controllers/*')
);

foreach ($files_to_include as $filename) include $filename;
?>
