<?php
/**
 * This file contains the definition of the AccessoriesController class.
 */

namespace Controllers;

use \Models\Accessory;

/**
 * A controller to see accessories.
 */
class AccessoriesController extends Controller {
  /**
   * GET /accessories
   * List all the accessories.
   */
  public function index() {
    $this->accessories = Accessory::all();
    $this->accessory_with_most_ads = Accessory::with_most_ads();
  }
}
?>
