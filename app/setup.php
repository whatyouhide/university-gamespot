<?php
// Define some constants.
define('SITE_NAME', 'gamespot');
define('SITE_ROOT', '/' . SITE_NAME);
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/' . SITE_NAME);

// Augment the include path.
set_include_path(ROOT);
// set_include_path(ROOT . '/lib/phpmailer');

// Make $_SESSION available.
session_start();

// Include some classes that will be used everywhere in the application.
include 'app/gamespot-smarty.class.php';
include 'app/db.class.php';
include 'app/model.class.php';
include 'app/controller.class.php';
include 'app/session.class.php';
include 'app/request.class.php';
include 'app/mailer.class.php';

// Include some utility functions.
include 'app/functions.php';

// Include all the models and the controllers.
// Also include all the Smarty helpers.
$files_to_include = array_merge(
  glob(ROOT . '/app/helpers/*'),
  glob(ROOT . '/app/models/*'),
  glob(ROOT . '/app/controllers/*')
);

foreach ($files_to_include as $filename) include $filename;
?>
