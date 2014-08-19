<?php
/**
 * The name of the website.
 */
define('SITE_NAME', 'gamespot');

/**
 * The root of the website, `/...`.
 */
define('SITE_ROOT', '/' . SITE_NAME);

/**
 * The root of the website as an absolute path on the server.
 */
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/' . SITE_NAME);

/**
 * The uploads directory.
 */
define('UPLOADS_DIR', ROOT . '/public/uploads');
?>
