<?php
/**
 * This file contains the definition of the Session class.
 */

/**
 * The controller for the backend home page.
 * @package Gamespot
 * @subpackage Controllers
 */
class BackendApplicationController extends BackendController {
  /**
   * GET /
   */
  public function index() {
    $this->restrict_to_staff_members();
    $this->render('index');
  }
}
?>
