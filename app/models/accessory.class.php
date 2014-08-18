<?php
class Accessory extends Model {
  public static $table_name = 'accessories';

  /**
   * {@inheritdoc}
   * Also fetch the image associated with this accessory.
   */
  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->image = $this->associated_image();
  }

  /**
   * Fetch the image associated with this accessory.
   * @return Upload The image associated with this accessory.
   */
  public function associated_image() {
    return Upload::find_by_attribute('accessory_image_id', $this->id);
  }
}

Accessory::$db = new DB;
?>
