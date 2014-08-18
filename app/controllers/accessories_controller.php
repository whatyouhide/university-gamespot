<?php
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
