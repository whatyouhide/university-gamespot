<?php
/**
 * This file contains the definition of the Uploader class.
 */

namespace Common;

/**
 * An interface to the uploaded files ($_FILES).
 */
class Uploader {
  /**
   * Retrieve a value in $_FILES. Return null if the value is not present or is
   * an empty upload.
   * @param string $param_name The key to search for in $_FILES.
   * @return mixed Null if there's no such file or is empty, the uploaded file
   * otherwise.
   */
  public static function get($param_name) {
    if (!isset($_FILES[$param_name])) { return null; }

    $file = $_FILES[$param_name];
    return self::is_empty($file) ? null : $file;
  }

  /**
   * Return true if the given uploaded file is empty, false otherwise.
   * @param array $file The uploaded file.
   * @return bool
   */
  private static function is_empty($file) {
    return (!$file || empty($file['name']));
  }
}
?>
