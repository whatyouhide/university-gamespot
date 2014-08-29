<?php
/**
 * This files contains a bunch of constants definitions.
 */

// Note: all the paths in this file are assumed without the trailing '/'
// character.

$conf = $GLOBALS['config']['site'];

/** The host of the website. */
define('HOST', $conf['host']);

/** The root of the website. */
define('SITE_ROOT', $conf['relative_path']);

/** The root of the website on the filesystem. */
if (isset($conf['root_directory'])) {
  define('ROOT', $conf['root_directory']);
} else {
  define('ROOT', $_SERVER['DOCUMENT_ROOT']);
}

/** The uploads directory. */
define('UPLOADS_DIR', ROOT . '/public/uploads');
?>
