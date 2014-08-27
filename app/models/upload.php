<?php
/**
 * This file contains the definition of the Upload class.
 */

/**
 * An uploaded file.
 */
class Upload extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'uploads';

  /**
   * Create an Upload record from a PHP-style uploaded files (generally taken
   * from `$_FILES`).
   * @param mixed $file A file taken from `$_FILES`.
   * @return null|Upload A new upload record or null if the upload went bad.
   */
  public static function create_from_uploaded_file($file) {
    // Create a new upload without an `url` attribute (we need an `id`).
    $new_upload = self::create_without_url($file);

    // Create a directory named as the `id` of the newly created upload.
    mkdir($new_upload->absolute_destination_dir());

    // Move the uploaded file to the right directory and throw an exception if
    // the upload failed.
    if ($new_upload->move_uploaded($file)) {
      $url = $new_upload->id . '/' . basename($file['name']);
      return $new_upload->update(['url' => $url]);
    } else {
      throw new Exception("Upload failed for file {$file['name']}");
    }
  }

  /**
   * Move an uploaded file to the destination directory for this  upload.
   * @param mixed $file An uploaded file.
   */
  public function move_uploaded($file) {
    return move_uploaded_file(
      $file['tmp_name'],
      $this->absolute_destination_dir() . '/' . basename($file['name'])
    );
  }

  /**
   * Return the destination directory of this upload.
   * @return string The destination directory (absolute path) for this upload.
   */
  public function absolute_destination_dir() {
    return (UPLOADS_DIR . '/' . $this->id);
  }

  /**
   * {@inheritdoc}
   * Also destroy the actual uploaded file with its containing directory.
   */
  public function destroy() {
    unlink($this->absolute_path());
    rmdir($this->absolute_destination_dir());
    parent::destroy();
  }

  /**
   * Create a new upload with no `url` attribute, with just a `mime_type` and a
   * `size`.
   * @param mixed $file An uploaded file.
   * @return Upload An upload instance.
   */
  private static function create_without_url($file) {
    return self::create([
      'mime_type' => $file['type'],
      'size' => $file['size']
    ]);
  }

  /**
   * Return the absolute path of this file on the server.
   * @return string The absolute path of this file.
   */
  private function absolute_path() {
    return (UPLOADS_DIR . '/' . $this->url);
  }
}
?>
