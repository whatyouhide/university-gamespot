<?php
/**
 * This file contains the definition of the ApplicationController class.
 */

namespace Controllers;

/**
 * The controller that responds to requests to `/`.
 */
class ApplicationController extends Controller {
  /**
   * GET /
   * The homepage of the website.
   */
  public function index() {
    $this->render('index');
  }
}
?>
