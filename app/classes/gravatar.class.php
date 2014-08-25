<?php
/**
 * This file contains the definition of the Gravatar class.
 */

/**
 * This class is responsible of communicating with the Gravatar API.
 */
class Gravatar {
  const BASE_URL = 'http://www.gravatar.com/avatar/';

  const SIZE_IN_PIXELS = 800;

  private static $default_parameters = array(
    // The default size in pixels.
    's' => self::SIZE_IN_PIXELS,
    // Default image.
    'd' => 'mm',
    // Rating.
    'r' => 'g'
  );

  public static function get($email) {
    $url = self::BASE_URL;
    $url .= self::sanitize_email($email);
    $url .= '?';
    $url .= http_build_query(self::$default_parameters);

    return $url;
  }

  private static function sanitize_email($email) {
    return md5(strtolower(trim($email)));
  }
}
?>
