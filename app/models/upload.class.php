<?php
class Upload extends Model {
  public static $table_name = 'uploads';

  /**
   * Create an Upload record from a PHP-style uploaded files (generally taken
   * from `$_FILES`).
   * @return null|Upload A new upload record or null if the upload went bad.
   */
  public static function create_from_uploaded_file($file) {
    $filename = $file['name'];

    $new_upload = Upload::create([
      'url' => $filename,
      'mime_type' => $file['type'],
      'size' => $file['size']
    ]);

    $destination = UPLOADS_DIR . '/' . basename($filename);
    $success = move_uploaded_file($file['tmp_name'], $destination);

    return $success ? $new_upload : null;
  }

  /**
   * {@inheritdoc}
   * Also destroy the actual uploaded file.
   */
  public function destroy() {
    unlink(UPLOADS_DIR . '/' . $this->url);
    parent::destroy();
  }
}

Upload::$db = new DB;
?>
