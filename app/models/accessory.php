<?php
/**
 * This file contains the definition of the Accessory class.
 */

namespace Models;

/**
 * Accessories for consoles.
 */
class Accessory extends Model {
  /**
   * {@inheritdoc}
   */
  public static $table_name = 'accessories';

  /**
   * {@inheritdoc}
   * Also fetch the image associated with this accessory.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->image = $this->associated_image();
    $this->console = $this->associated_console();
  }

  /**
   * Update the cover image of this game to the given Upload instance. If the
   * $upload parameter is null or '', just remove the cover image of the game.
   * The previous cover image will be deleted anyways.
   * @param null|Upload $upload The new image for this record, or null to
   * destroy the image.
   */
  public function update_image($upload) {
    $this->delete_image();

    if (!empty($upload)) {
      $upload->update(['accessory_image_id' => $this->id]);
      $this->image = $upload;
    }
  }

  /**
   * {@inheritdoc}
   * Also destroy all the ads associated with this accessory.
   */
  public function destroy() {
    $ads = Ad::associated_with_accessory($this->id);
    foreach ($ads as $ad) {
      $ad->destroy();
    }

    parent::destroy();
  }

  /**
   * {@inheritdoc}
   */
  public static function validate($attributes) {
    $validator = new Validator($attributes);

    $validator->must_not_be_empty('name');
    $validator->must_not_be_empty('producer');
    $validator->must_not_be_empty('console_id');
    $validator->must_not_be_empty('release_date');

    return $validator->error_messages();
  }

  /**
   * Fetch the image associated with this accessory.
   * @return Upload
   */
  private function associated_image() {
    return Upload::find_by_attribute('accessory_image_id', $this->id);
  }

  /**
   * Fetch the console assocciated with this accessory.
   * @return Console
   */
  private function associated_console() {
    return Console::find($this->console_id);
  }

  /**
   * Delete the image associated with this record. If there weren't any, do
   * nothing.
   */
  private function delete_image() {
    if (!$this->image) { return; }
    $this->image->destroy();
    $this->image = null;
  }
}
?>
