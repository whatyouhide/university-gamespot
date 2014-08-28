<?php
/**
 * This file contains the definition of the Gravatar class.
 */

namespace Common;

/**
 * This class is responsible of communicating with the Gravatar API.
 */
class Gravatar {
  /**
   * The Gravatar API base url.
   */
  const BASE_URL = 'http://www.gravatar.com/avatar/';

  /**
   * The size of the image.
   */
  const SIZE_IN_PIXELS = 800;

  /**
   * @var array Default parameters for the Gravatar API.
   */
  private static $default_parameters = array(
    // The default size in pixels.
    's' => self::SIZE_IN_PIXELS,
    // Default image.
    'd' => 'mm',
    // Rating.
    'r' => 'g'
  );

  /**
   * Get the avatar associated with $email.
   * @param string $email
   * @return string The URL of the retrieved image.
   */
  public static function get($email) {
    $url = self::BASE_URL;
    $url .= self::sanitize_email($email);
    $url .= '?';
    $url .= http_build_query(self::$default_parameters);

    return $url;
  }

  /**
   * Sanitize an email address for use in the parameters for the Gravatar API.
   * Also compute an md5 hash of the email.
   * @param string $email
   * @return string
   */
  private static function sanitize_email($email) {
    return md5(strtolower(trim($email)));
  }
}
?>
