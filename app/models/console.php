<?php
/**
 * This file contains the definition of the Console class.
 */

namespace Models;

/**
 * A console.
 */
class Console extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'consoles';

  /**
   * {@inheritdoc}
   * Also fetch the image associated with this console.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->image = $this->associated_image();
  }

  /**
   * Update the image of this console to a given Upload instance. Delete the
   * image that was asssociated with this record first (if there was one).
   * @param Upload $upload The new image for this record.
   */
  public function update_image($upload) {
    $this->delete_image();
    $upload->update(['console_image_id' => $this->id]);
    $this->image = $upload;
  }

  /**
   * Delete the image associated with this record. If there weren't any, do
   * nothing.
   */
  public function delete_image() {
    if (!$this->image) { return; }
    $this->image->destroy();
    $this->image = null;
  }

  /**
   * {@inheritdoc}
   */
  public static function validate($attrs) {
    $validator = new Validator($attrs);

    $validator->must_not_be_empty('name');
    $validator->must_not_be_empty('producer');
    $validator->must_not_be_empty(
      'release_year',
      'The release year must not be empty'
    );
    $validator->must_be_int(
      'release_year',
      'The release year must be an integer'
    );

    return $validator->error_messages();
  }

  /**
   * Fetch the image associated with this record.
   * @return Upload
   */
  private function associated_image() {
    return Upload::find_by_attribute('console_image_id', $this->id);
  }
}
?>
