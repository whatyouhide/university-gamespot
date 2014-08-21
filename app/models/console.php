<?php
/**
 * @package Gamespot
 * @subpackage Models
 */
class Console extends Model {
  public static $table_name = 'consoles';

  public function __construct($attributes) {
    parent::__construct($attributes);
    $this->image = $this->associated_image();
  }

  public function update_image($upload) {
    $this->delete_image();
    $upload->update(['console_image_id' => $this->id]);
    $this->image = $upload;
  }

  public function delete_image() {
    if (!$this->image) { return; }
    $this->image->destroy();
    $this->image = null;
  }

  private function associated_image() {
    return Upload::find_by_attribute('console_image_id', $this->id);
  }
}
?>
