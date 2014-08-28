<?php
/**
 * This file contains the definition of the Session class.
 */

namespace Controllers;

/**
 * The controller for the backend home page.
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
