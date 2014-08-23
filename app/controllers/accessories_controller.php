<?php
/**
 * This file contains the definition of the AccessoriesController class.
 */

/**
 * A controller to see accessories.
 * @package Gamespot
 * @subpackage Controllers
 */
class AccessoriesController extends Controller {
  /**
   * GET /accessories
   * List all the accessories.
   */
  public function index() {
    $accessories = Accessory::all();
    $this->render('accessories/index', ['accessories' => $accessories]);
  }
}
?>
