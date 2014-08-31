<?php
/**
 * This file contains the definition of the BackendErrorsController class.
 */

namespace Controllers;

use Models\Error;

/**
 * A controller for viewing errors.
 */
class BackendErrorsController extends BackendController {
  /**
   * GET /errors
   * See a list of the errors.
   */
  public function index() {
    $this->errors = Error::all();
  }
}
?>
